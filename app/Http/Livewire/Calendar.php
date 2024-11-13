<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Solicitud;
use App\Models\Auditorio;

class Calendar extends Component
{
    public $solicitudes = [];
    public $currentMonth;
    public $currentYear;
    public $search = '';
    public $estadoFilter = '';
    public $auditorioFilter = '';
    public $auditorios = [];

    public function mount()
    {
        $this->setCurrentDate();
        $this->auditorios = Auditorio::all();
        $this->filtrar();
    }

    public function updatedSearch()
    {
        $this->filtrar();
    }

    public function updatedEstadoFilter()
    {
        $this->filtrar();
    }

    public function updatedAuditorioFilter()
    {
        $this->filtrar();
    }

    public function setCurrentDate()
    {
        $monthNames = [
            'Enero',
            'Febrero',
            'Marzo',
            'Abril',
            'Mayo',
            'Junio',
            'Julio',
            'Agosto',
            'Septiembre',
            'Octubre',
            'Noviembre',
            'Diciembre'
        ];

        $this->currentMonth = $monthNames[date('n') - 1];
        $this->currentYear = date('Y');
    }

    public function filtrar()
    {
        $this->solicitudes = Solicitud::with('auditorio', 'equipos', 'user')
            ->when($this->estadoFilter, function ($query) {
                return $query->where('estado', $this->estadoFilter);
            })
            ->when($this->auditorioFilter, function ($query) {
                return $query->whereHas('auditorio', function ($q) {
                    $q->where('nombre', $this->auditorioFilter);
                });
            })
            ->get()
            ->map(function ($solicitud) {
                return [
                    'auditorio' => $solicitud->auditorio->nombre,
                    'fecha_uso' => $solicitud->fecha_uso,
                    'hora_inicio' => $solicitud->hora_inicio,
                    'hora_final' => $solicitud->hora_final,
                    'actividad' => $solicitud->actividad,
                    'equipos' => $solicitud->equipos->pluck('nombre')->join(', '),
                    'usuario' => $solicitud->user->first_name . ' ' . $solicitud->user->last_name,
                    'estado' => $solicitud->estado,
                ];
            })
            ->groupBy('fecha_uso');
    }

    public function render()
    {
        return view('livewire.calendar', [
            'currentMonth' => $this->currentMonth,
            'currentYear' => $this->currentYear,
            'solicitudes' => $this->solicitudes,
            'auditorios' => $this->auditorios,
        ]);
    }
}