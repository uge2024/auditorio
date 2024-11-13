<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Solicitud;
use App\Models\User;
use App\Models\Auditorio;
use Carbon\Carbon;

class Reportes extends Component
{
    public $reportes;
    public $fechaInicio;
    public $fechaFin;
    public $usuarioId;
    public $auditorioId;
    public $estado;
    public $actividad;

    public function mount()
    {
        $this->fechaInicio = Carbon::today()->toDateString();
        $this->fechaFin = Carbon::today()->toDateString();
        $this->loadReports();
    }

    public function loadReports()
    {
        $query = Solicitud::with(['user', 'auditorio', 'equipos'])
            ->whereBetween('fecha_uso', [$this->fechaInicio, $this->fechaFin]);

        if ($this->usuarioId) {
            $query->where('id_usuario', $this->usuarioId);
        }

        // Asegúrate de que aquí estás aplicando correctamente el filtro del auditorio
        if ($this->auditorioId) {
            $query->where('id_auditorio', $this->auditorioId);
        }

        if ($this->estado) {
            $query->where('estado', $this->estado);
        }

        if ($this->actividad) {
            $query->where('actividad', 'like', '%' . $this->actividad . '%');
        }

        $this->reportes = $query->latest()->get();
    }


    public function filterReports()
    {
        $this->loadReports();
    }

    public function exportToPdf()
    {
        $reportes = $this->getFilteredReports();

        if ($reportes->isEmpty()) {
            session()->flash('error', 'No hay reportes para exportar.');
            return;
        }

        try {
            $pdf = Pdf::loadView('pdf.reportes', ['reportes' => $reportes])
                ->setPaper('letter', 'landscape');

            return response()->stream(function () use ($pdf) {
                echo $pdf->output();
            }, 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="reportes_' . now()->format('Ymd') . '.pdf"',
            ]);
        } catch (\Exception $e) {
            logger()->error('Error al generar PDF: ' . $e->getMessage());
            session()->flash('error', 'Error al generar PDF: ' . $e->getMessage());
        }
    }

    protected function getFilteredReports()
    {
        return Solicitud::with(['user', 'auditorio', 'equipos'])
            ->whereBetween('fecha_uso', [$this->fechaInicio, $this->fechaFin])
            ->when($this->usuarioId, function ($query) {
                $query->where('id_usuario', $this->usuarioId);
            })
            ->when($this->auditorioId, function ($query) {
                $query->where('id_auditorio', $this->auditorioId);
            })
            ->when($this->estado, function ($query) {
                $query->where('estado', $this->estado);
            })
            ->when($this->actividad, function ($query) {
                $query->where('actividad', 'like', '%' . $this->actividad . '%');
            })
            ->latest()
            ->get();
    }

    public function render()
    {
        $usuarios = User::all();
        $auditorios = Auditorio::all();

        return view('livewire.reportes', [
            'usuarios' => $usuarios,
            'auditorios' => $auditorios,
        ]);
    }
}
