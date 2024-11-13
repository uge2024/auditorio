<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Solicitud;
use App\Models\Auditorio;
use App\Models\Equipo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;
use Livewire\WithPagination;
use Barryvdh\DomPDF\Facade\Pdf;

class CreateSolicitudUser extends Component
{
    use WithPagination;

    public $auditorios;
    public $equipos;
    public $filteredEquipos = [];
    public $selectedEquipos = [];
    public $solicitud = [
        'id_auditorio' => '',
        'fecha_uso' => '',
        'hora_inicio' => '',
        'hora_final' => '',
        'actividad' => '',
        'estado' => 'pendiente',
    ];
    public $solicitudesPorFecha = [];  // Cambiado a arreglo
    public $horasPermitidas = [
        '08:00',
        '08:30',
        '09:00',
        '09:30',
        '10:00',
        '10:30',
        '11:00',
        '11:30',
        '12:00',
        '14:30',
        '15:00',
        '15:30',
        '16:00',
        '16:30',
        '17:00',
        '17:30',
        '18:00',
        '18:30'
    ];
    public $editMode = false;
    public $editId = null;
    public $selectedSolicitud = null;

    protected $rules = [
        'solicitud.id_auditorio' => 'required|exists:auditorio,id_auditorio',
        'solicitud.fecha_uso' => 'required|date|after_or_equal:today',
        'solicitud.hora_inicio' => 'required|date_format:H:i',
        'solicitud.hora_final' => 'required|date_format:H:i|after:solicitud.hora_inicio',
        'solicitud.actividad' => 'required|string|max:255',
        'selectedEquipos' => 'nullable|array|max:5',
        'selectedEquipos.*' => 'exists:equipo,id_equipo',
    ];

    protected $messages = [
        'solicitud.hora_inicio.required' => 'Selecciona una hora de inicio válida.',
        'solicitud.hora_final.required' => 'Selecciona una hora de finalización válida.',
        'solicitud.actividad.required' => 'Describe la actividad que realizarás.',
        'solicitud.fecha_uso.after_or_equal' => 'La fecha de uso debe ser hoy o una fecha futura.',
        'solicitud.id_auditorio.required' => 'Debes seleccionar un auditorio.',
        'selectedEquipos.max' => 'Puedes seleccionar un máximo de 5 equipos.',
    ];

    public function mount()
    {
        if (!Auth::check()) {
            session()->flash('error', 'Debes estar autenticado.');
            return redirect()->route('login');
        }


        $this->auditorios = Auditorio::all();
        $this->equipos = Equipo::all();
    }

    public function updated($propertyName)
    {
        if ($propertyName === 'solicitud.id_auditorio') {
            $this->filterEquiposByAuditorio();
        }

        if ($propertyName === 'solicitud.fecha_uso') {
            $this->loadSolicitudesPorFecha();
        }
    }

    public function filterEquiposByAuditorio()
    {
        if ($this->solicitud['id_auditorio']) {
            $this->filteredEquipos = Equipo::where('id_auditorio', $this->solicitud['id_auditorio'])->get();
        } else {
            $this->filteredEquipos = [];
        }
    }

    public function loadSolicitudesPorFecha()
    {
        if ($this->solicitud['fecha_uso'] && $this->solicitud['id_auditorio']) {
            $this->solicitudesPorFecha = Solicitud::whereDate('fecha_uso', $this->solicitud['fecha_uso'])
                ->where('id_auditorio', $this->solicitud['id_auditorio'])  // Filtro adicional por auditorio
                ->whereIn('estado', ['pendiente', 'aprobado'])
                ->with('auditorio', 'user')
                ->get()
                ->toArray();
        }
    }


    public function viewSolicitud($id)
    {
        $this->selectedSolicitud = Solicitud::with(['user', 'equipos', 'auditorio'])
            ->where('id_solicitud', $id)
            ->firstOrFail();

        $this->dispatchBrowserEvent('show-modal');
    }
    public function exportToPDF($id)
    {
        $solicitud = Solicitud::with(['user', 'equipos', 'auditorio'])->findOrFail($id);
        $pdf = Pdf::loadView('pdf.solicitud-pdf', ['solicitud' => $solicitud]);
        return $pdf->download('solicitud-detalles.pdf');
    }

    public function submit()
    {
        $this->validate();

        $horaInicio = Carbon::createFromFormat('H:i', $this->solicitud['hora_inicio']);
        $horaFinal = Carbon::createFromFormat('H:i', $this->solicitud['hora_final']);
        $duracion = $horaInicio->diffInMinutes($horaFinal);

        if (!in_array($horaInicio->format('H:i'), $this->horasPermitidas) || !in_array($horaFinal->format('H:i'), $this->horasPermitidas)) {
            throw ValidationException::withMessages([
                'solicitud.hora_inicio' => 'La hora de inicio debe ser permitida.',
                'solicitud.hora_final' => 'La hora de finalización debe ser permitida.',
            ]);
        }

        if ($duracion < 30 || $duracion > 240) {
            throw ValidationException::withMessages([
                'solicitud.hora_final' => 'La duración debe ser entre 30 minutos y 4 horas.',
            ]);
        }

        $overlap = Solicitud::where('id_auditorio', $this->solicitud['id_auditorio'])
            ->where('fecha_uso', $this->solicitud['fecha_uso'])
            ->where(function ($query) use ($horaInicio, $horaFinal) {
                $query->whereBetween('hora_inicio', [$horaInicio, $horaFinal])
                    ->orWhereBetween('hora_final', [$horaInicio, $horaFinal])
                    ->orWhere(function ($q) use ($horaInicio, $horaFinal) {
                        $q->where('hora_inicio', '<=', $horaInicio)
                            ->where('hora_final', '>=', $horaFinal);
                    });
            })
            ->when($this->editMode, function ($query) {
                $query->where('id_solicitud', '<>', $this->editId);
            })
            ->exists();

        if ($overlap) {
            throw ValidationException::withMessages([
                'solicitud.id_auditorio' => 'El auditorio ya está solicitado en este horario.',
            ]);
        }

        $solicitudData = array_merge($this->solicitud, ['id_usuario' => Auth::id()]);
        if ($this->editMode) {
            $solicitud = Solicitud::find($this->editId);
            $solicitud->update($solicitudData);
        } else {
            $solicitud = Solicitud::create($solicitudData);
        }

        $solicitud->equipos()->sync($this->selectedEquipos);

        session()->flash('message', $this->editMode ? 'Solicitud actualizada exitosamente.' : 'Solicitud creada exitosamente.');
        $this->resetForm();
    }

    public function edit($id)
    {
        $solicitud = Solicitud::find($id);
        if (!$solicitud || $solicitud->estado !== 'pendiente') {
            session()->flash('error', 'Solicitud no encontrada o no editable.');
            return;
        }

        $this->solicitud = $solicitud->toArray();
        $this->selectedEquipos = $solicitud->equipos->pluck('id_equipo')->toArray();
        $this->editMode = true;
        $this->editId = $id;

        $this->filterEquiposByAuditorio();
    }

    public function cancel($id)
    {
        $solicitud = Solicitud::find($id);
        if (!$solicitud || $solicitud->estado !== 'pendiente') {
            session()->flash('error', 'Solicitud no encontrada o no cancelable.');
            return;
        }

        $solicitud->delete();
        session()->flash('message', 'Solicitud cancelada exitosamente.');
    }

    public function resetForm()
    {
        $this->solicitud = [
            'id_auditorio' => '',
            'fecha_uso' => '',
            'hora_inicio' => '',
            'hora_final' => '',
            'actividad' => '',
            'estado' => 'pendiente',
        ];
        $this->selectedEquipos = [];
        $this->editMode = false;
        $this->editId = null;
        $this->filteredEquipos = [];
    }

    public function render()
    {
        $solicitudesDelUsuario = Solicitud::where('id_usuario', Auth::id())
            ->with('auditorio')
            ->paginate(10);

        return view('livewire.create-solicitud-user', [
            'auditorios' => $this->auditorios,
            'equipos' => $this->equipos,
            'solicitudesDelUsuario' => $solicitudesDelUsuario,
        ]);
    }
}
