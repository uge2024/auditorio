<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Solicitud;
use App\Models\Auditorio;
use App\Models\Equipo;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class CreateSolicitud extends Component
{
    public $auditorios;
    public $equipos;
    public $selectedEquipos = [];
    public $solicitud = [
        'id_auditorio' => '',
        'fecha_uso' => '',
        'hora_inicio' => '',
        'hora_final' => '',
        'actividad' => '',
        'estado' => 'pendiente',
    ];
    public $solicitudes = [];
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
    public $solicitudesaprobados = [];
    public $selectedDate;
    public $search = '';
    public $statusFilter = '';

    protected $rules = [
        'solicitud.id_auditorio' => 'required|exists:auditorio,id_auditorio',
        'solicitud.fecha_uso' => 'required|date|date_format:Y-m-d|after_or_equal:today',
        'solicitud.hora_inicio' => 'required|date_format:H:i',
        'solicitud.hora_final' => 'required|date_format:H:i|after:solicitud.hora_inicio',
        'solicitud.actividad' => 'required|string|max:255',
        'selectedEquipos' => 'nullable|array|min:1',
        'selectedEquipos.*' => 'exists:equipo,id_equipo',
    ];

    public function mount()
    {
        if (!Auth::check()) {
            session()->flash('error', 'No estás autenticado.');
            return redirect()->route('login');
        }


        $this->auditorios = Auditorio::all();
        $this->equipos = Equipo::all();
        $this->loadSolicitudes();
        $this->loadSolicitudesaprobados();
    }

    public function updated($propertyName)
    {
        if ($propertyName === 'selectedDate') {
            $this->loadSolicitudesaprobados();
        }

        if ($propertyName === 'search' || $propertyName === 'statusFilter') {
            $this->loadSolicitudes();
        }
    }

    public function loadSolicitudesaprobados()
    {
        if ($this->selectedDate) {
            $this->solicitudesaprobados = Solicitud::where('fecha_uso', $this->selectedDate)
                ->where('estado', 'aprobado')
                ->with('auditorio', 'user')
                ->get();
        } else {
            $this->solicitudesaprobados = [];
        }
    }

    public function loadSolicitudes()
    {
        $query = Solicitud::with('auditorio', 'equipos')
            ->when($this->search, function ($query) {
                $query->where('actividad', 'like', '%' . $this->search . '%');
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('estado', $this->statusFilter);
            })
            ->when(!empty($this->solicitud['fecha_uso']), function ($query) {
                $query->where('fecha_uso', $this->solicitud['fecha_uso']);
            });

        $this->solicitudes = $query->get();
    }



    public function submit()
    {
        $this->validate();

        $horaInicio = Carbon::createFromFormat('H:i', $this->solicitud['hora_inicio']);
        $horaFinal = Carbon::createFromFormat('H:i', $this->solicitud['hora_final']);
        $horaInicioMargen = $horaInicio->copy()->addMinute();
        $horaFinalMargen = $horaFinal->copy()->subMinute();
        $duracion = $horaInicio->diffInMinutes($horaFinal);

        if (!in_array($horaInicio->format('H:i'), $this->horasPermitidas) || !in_array($horaFinal->format('H:i'), $this->horasPermitidas)) {
            throw ValidationException::withMessages([
                'solicitud.hora_inicio' => 'La hora de inicio debe ser una de las horas permitidas.',
                'solicitud.hora_final' => 'La hora de finalización debe ser una de las horas permitidas.',
            ]);
        }

        if ($duracion < 30 || $duracion > 240) {
            throw ValidationException::withMessages([
                'solicitud.hora_final' => 'La duración de la solicitud debe estar entre 30 minutos y 4 horas.',
            ]);
        }

        $this->checkAllowedHours($horaInicio, $horaFinal);

        $overlap = Solicitud::where('id_auditorio', $this->solicitud['id_auditorio'])
            ->where('fecha_uso', $this->solicitud['fecha_uso'])
            ->where(function ($query) use ($horaInicioMargen, $horaFinalMargen) {
                $query->where(function ($q) use ($horaInicioMargen, $horaFinalMargen) {
                    $q->whereBetween('hora_inicio', [$horaInicioMargen->format('H:i'), $horaFinalMargen->format('H:i')])
                        ->orWhereBetween('hora_final', [$horaInicioMargen->format('H:i'), $horaFinalMargen->format('H:i')])
                        ->orWhere(function ($q) use ($horaInicioMargen, $horaFinalMargen) {
                            $q->where('hora_inicio', '<=', $horaInicioMargen->format('H:i'))
                                ->where('hora_final', '>=', $horaFinalMargen->format('H:i'));
                        });
                });
            })
            ->when($this->editMode, function ($query) {
                $query->where('id_solicitud', '<>', $this->editId);
            })
            ->exists();

        if ($overlap) {
            throw ValidationException::withMessages([
                'solicitud.id_auditorio' => 'El auditorio ya está solicitado en el horario seleccionado.',
            ]);
        }

        $solicitudData = array_merge($this->solicitud, ['id_usuario' => Auth::id()]);

        if ($this->editMode) {
            $solicitud = Solicitud::find($this->editId);
            $solicitud->update($solicitudData);
        } else {
            $solicitud = Solicitud::create($solicitudData);

            // Create notification for admin
            Notification::create([
                'user_id' => 1, // Replace '1' with the actual admin user ID
                'message' => 'A new solicitud has been registered by ' . Auth::user()->name,
                'read' => false, // Mark as unread initially
            ]);
        }

        $solicitud->equipos()->sync($this->selectedEquipos);

        session()->flash('message', $this->editMode ? 'Solicitud actualizada exitosamente.' : 'Solicitud creada exitosamente.');
        $this->loadSolicitudes();
        $this->resetForm();
    }


    protected function checkAllowedHours($horaInicio, $horaFinal)
    {
        $inicioPermitido1 = Carbon::createFromFormat('H:i', '08:00');
        $finPermitido1 = Carbon::createFromFormat('H:i', '12:00');
        $inicioPermitido2 = Carbon::createFromFormat('H:i', '14:30');
        $finPermitido2 = Carbon::createFromFormat('H:i', '18:30');

        if (($horaInicio->lt($inicioPermitido1) || $horaFinal->gt($finPermitido1)) && ($horaInicio->lt($inicioPermitido2) || $horaFinal->gt($finPermitido2))) {
            throw ValidationException::withMessages([
                'solicitud.hora_inicio' => 'La solicitud debe estar dentro de los horarios permitidos: 08:00-12:00 o 14:30-18:30.',
                'solicitud.hora_final' => 'La solicitud debe estar dentro de los horarios permitidos: 08:00-12:00 o 14:30-18:30.',
            ]);
        }
    }

    public function edit($id)
    {
        $solicitud = Solicitud::find($id);
        if (!$solicitud) {
            session()->flash('error', 'Solicitud no encontrada.');
            return;
        }

        $this->solicitud = $solicitud->toArray();
        $this->selectedEquipos = $solicitud->equipos->pluck('id_equipo')->toArray();
        $this->editMode = true;
        $this->editId = $id;

        $this->dispatchBrowserEvent('openEditModal');
    }

    public function delete($id_solicitud)
    {
        $solicitud = Solicitud::find($id_solicitud);
        if ($solicitud) {
            $solicitud->delete();
            session()->flash('message', 'Solicitud eliminada exitosamente.');
            $this->loadSolicitudes();
        } else {
            session()->flash('error', 'Solicitud no encontrada.');
        }
    }

    public function accept($id)
    {
        $solicitud = Solicitud::find($id);
        if ($solicitud) {
            $solicitud->update(['estado' => 'aprobado']);

            // Notificación para usuario
            Notification::create([
                'user_id' => $solicitud->id_usuario,
                'message' => 'Tu solicitud ha sido aprobada.',
                'type' => 'interaccion',
                'read' => false,
            ]);

            session()->flash('message', 'Solicitud aprobada.');
            $this->loadSolicitudes();
        } else {
            session()->flash('error', 'Solicitud no encontrada.');
        }
    }

    public function reject($id)
    {
        $solicitud = Solicitud::find($id);
        if ($solicitud) {
            $solicitud->update(['estado' => 'rechazado']);

            // Notificación para usuario
            Notification::create([
                'user_id' => $solicitud->id_usuario,
                'message' => 'Tu solicitud ha sido rechazada.',
                'type' => 'interaccion',
                'read' => false,
            ]);

            session()->flash('message', 'Solicitud rechazada.');
            $this->loadSolicitudes();
        } else {
            session()->flash('error', 'Solicitud no encontrada.');
        }
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
        $this->search = '';
        $this->statusFilter = '';
    }

    public function render()
    {
        return view('livewire.create-solicitud');
    }
}
