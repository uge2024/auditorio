<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Auditorio;
use App\Models\Solicitud;
use App\Models\Equipo;

class Dashboard extends Component
{
    public $auditorios;
    public $usuariosActivos;
    public $eventos;
    public $selectedEquipos = [];
    public $auditorioSeleccionado = null;
    public $calendarioSolicitudes = [];
    public $loading = false;
    public $selectedSolicitud = null;

    // Filtros
    public $filtroCapacidad;
    public $filtroDisponibilidad;
    public $filtroEquipos;

    public function mount()
    {
        $this->loading = true;
        $this->auditorios = Auditorio::with('equipos')->get();
        $this->usuariosActivos = User::where('estatus', 'activo')->count();
        // Cargar las solicitudes junto con la relación 'auditorio'
        $this->calendarioSolicitudes = Solicitud::with('auditorio')->get();
        $this->loading = false;
    }

    public function showEquipos($auditorioId)
    {
        $this->auditorioSeleccionado = $auditorioId;
        $this->selectedEquipos = Equipo::where('id_auditorio', $auditorioId)->get();
    }

    public function reserveAuditorio($auditorioId)
    {
        session()->flash('message', 'Reserva solicitada para el auditorio ID: ' . $auditorioId);
    }

    public function selectSolicitud($solicitudId)
    {
        if ($solicitudId) {
            $this->selectedSolicitud = Solicitud::find($solicitudId);
        } else {
            $this->selectedSolicitud = null;
        }
    }

    public function isSolicitudDay($day)
    {
        foreach ($this->calendarioSolicitudes as $solicitud) {
            if (date('j', strtotime($solicitud->fecha_uso)) == $day) {
                return $solicitud;
            }
        }
        return null;
    }

    // Filtros
    public function updatedFiltroCapacidad()
    {
        $this->auditorios = Auditorio::where('capacidad', '>=', $this->filtroCapacidad)->get();
    }

    public function updatedFiltroDisponibilidad()
    {
        $this->auditorios = Auditorio::where('disponibilidad', $this->filtroDisponibilidad)->get();
    }

    public function updatedFiltroEquipos()
    {
        $this->auditorios = Auditorio::whereHas('equipos', function ($query) {
            $query->where('nombre', 'like', '%' . $this->filtroEquipos . '%');
        })->get();
    }

    public function render()
    {
        return view('dashboard', [
            'solicitudes' => $this->calendarioSolicitudes, // Pasamos las solicitudes a la vista
        ]);
    }
}