<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Auditorio;
use Illuminate\Support\Facades\Storage;

class AuditorioComponent extends Component
{
    use WithFileUploads;

    public $auditorios;
    public $id_auditorio;
    public $nombre;
    public $ubicacion;
    public $imagen;
    public $capacidad;
    public $descripcion;
    public $editMode = false;
    public $successMessage;

    public function mount()
    {
        $this->updateAuditorios();
    }

    public function submit()
    {
        $this->editMode ? $this->update() : $this->store();
    }

    public function store()
    {
        $this->validate([
            'nombre' => 'required|string|max:255',
            'ubicacion' => 'nullable|string|max:255',
            'imagen' => 'nullable|image|mimes:jpeg,png,gif,bmp,svg|max:1024',
            'capacidad' => 'required|integer',
            'descripcion' => 'nullable|string',
        ]);

        $imagenPath = $this->imagen ? $this->imagen->store('images', 'public') : null;

        Auditorio::create([
            'nombre' => $this->nombre,
            'ubicacion' => $this->ubicacion,
            'imagen' => $imagenPath,
            'capacidad' => $this->capacidad,
            'descripcion' => $this->descripcion,
        ]);

        $this->successMessage = 'Auditorio guardado exitosamente!';
        $this->dispatchBrowserEvent('notify-success');
        $this->dispatchBrowserEvent('close-modal');
        $this->resetModal();
        $this->updateAuditorios();
    }

    public function update()
    {
        $this->validate([
            'nombre' => 'required|string|max:255',
            'ubicacion' => 'nullable|string|max:255',
            'capacidad' => 'required|integer',
            'descripcion' => 'nullable|string',
        ]);

        $auditorio = Auditorio::find($this->id_auditorio);

        // Solo valida y guarda una nueva imagen si se ha subido una
        if ($this->imagen instanceof \Livewire\TemporaryUploadedFile) {
            if ($auditorio->imagen) {
                Storage::disk('public')->delete($auditorio->imagen);
            }
            $imagenPath = $this->imagen->store('images', 'public');
        } else {
            $imagenPath = $auditorio->imagen;
        }

        $auditorio->update([
            'nombre' => $this->nombre,
            'ubicacion' => $this->ubicacion,
            'imagen' => $imagenPath,
            'capacidad' => $this->capacidad,
            'descripcion' => $this->descripcion,
        ]);

        $this->successMessage = 'Auditorio actualizado exitosamente!';
        $this->dispatchBrowserEvent('notify-success');
        $this->dispatchBrowserEvent('close-modal');
        $this->resetModal();
        $this->updateAuditorios();
    }

    public function edit($id)
    {
        $this->editMode = true;
        $auditorio = Auditorio::findOrFail($id);
        $this->id_auditorio = $auditorio->id_auditorio;
        $this->nombre = $auditorio->nombre;
        $this->ubicacion = $auditorio->ubicacion;
        $this->imagen = $auditorio->imagen;
        $this->capacidad = $auditorio->capacidad;
        $this->descripcion = $auditorio->descripcion;
    }

    public function delete($id)
    {
        $auditorio = Auditorio::findOrFail($id);
        if ($auditorio->imagen) {
            Storage::disk('public')->delete($auditorio->imagen);
        }
        $auditorio->delete();
        $this->successMessage = 'Auditorio eliminado exitosamente!';
        $this->dispatchBrowserEvent('notify-success');
        $this->updateAuditorios();
    }

    public function resetModal()
    {
        $this->reset(['id_auditorio', 'nombre', 'ubicacion', 'imagen', 'capacidad', 'descripcion', 'editMode']);
        $this->successMessage = null;
    }

    public function updateAuditorios()
    {
        $this->auditorios = Auditorio::all();
    }

    public function render()
    {
        return view('livewire.auditorio-component');
    }
}
