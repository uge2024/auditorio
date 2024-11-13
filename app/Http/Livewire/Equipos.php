<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Equipo;
use App\Models\Auditorio;
use Illuminate\Support\Facades\Storage;

class Equipos extends Component
{
    use WithFileUploads;

    public $equipos;
    public $auditorios;
    public $id_equipo;
    public $nombre;
    public $codigo;
    public $imagen;
    public $descripcion;
    public $id_auditorio;
    public $editMode = false;
    public $successMessage;

    public function mount()
    {
        $this->updateEquipos();
        $this->auditorios = Auditorio::all();
    }

    public function submit()
    {
        $this->editMode ? $this->update() : $this->store();
    }

    public function store()
    {
        $this->validate([
            'nombre' => 'required|string|max:255',
            'codigo' => 'required|string|max:255|unique:equipo,codigo',
            'imagen' => 'nullable|image|mimes:jpeg,png,gif,bmp,svg|max:1024',
            'descripcion' => 'nullable|string',
            'id_auditorio' => 'required|exists:auditorio,id_auditorio',
        ]);

        $imagenPath = $this->imagen ? $this->imagen->store('images', 'public') : null;

        Equipo::create([
            'nombre' => $this->nombre,
            'codigo' => $this->codigo,
            'imagen' => $imagenPath,
            'descripcion' => $this->descripcion,
            'id_auditorio' => $this->id_auditorio,
        ]);

        $this->successMessage = 'Registro guardado exitosamente!';
        $this->dispatchBrowserEvent('notify-success');
        $this->dispatchBrowserEvent('close-modal'); // Cerrar modal después de guardar
        $this->resetModal();
        $this->updateEquipos();
    }

    public function update()
    {
        $this->validate([
            'nombre' => 'required|string|max:255',
            'codigo' => 'required|string|max:255|unique:equipo,codigo,' . $this->id_equipo . ',id_equipo',
            'descripcion' => 'nullable|string',
            'id_auditorio' => 'required|exists:auditorio,id_auditorio',
        ]);

        $equipo = Equipo::find($this->id_equipo);

        // Validar solo si hay una nueva imagen
        if ($this->imagen instanceof \Livewire\TemporaryUploadedFile) {
            if ($equipo->imagen) {
                Storage::disk('public')->delete($equipo->imagen);
            }
            $imagenPath = $this->imagen->store('images', 'public');
        } else {
            $imagenPath = $equipo->imagen;
        }

        $equipo->update([
            'nombre' => $this->nombre,
            'codigo' => $this->codigo,
            'imagen' => $imagenPath,
            'descripcion' => $this->descripcion,
            'id_auditorio' => $this->id_auditorio,
        ]);

        $this->successMessage = 'Registro actualizado exitosamente!';
        $this->dispatchBrowserEvent('notify-success');
        $this->dispatchBrowserEvent('close-modal'); // Cerrar modal después de actualizar
        $this->resetModal();
        $this->updateEquipos();
    }

    public function edit($id)
    {
        $this->editMode = true;
        $equipo = Equipo::findOrFail($id);
        $this->id_equipo = $equipo->id_equipo;
        $this->nombre = $equipo->nombre;
        $this->codigo = $equipo->codigo;
        $this->imagen = $equipo->imagen;
        $this->descripcion = $equipo->descripcion;
        $this->id_auditorio = $equipo->id_auditorio;
        $this->dispatchBrowserEvent('open-modal'); // Evento para abrir el modal
    }

    public function delete($id)
    {
        $equipo = Equipo::findOrFail($id);
        if ($equipo->imagen) {
            Storage::disk('public')->delete($equipo->imagen);
        }
        $equipo->delete();
        $this->successMessage = 'Registro eliminado exitosamente!';
        $this->dispatchBrowserEvent('notify-success');
        $this->updateEquipos();
    }

    public function resetModal()
    {
        $this->reset(['id_equipo', 'nombre', 'codigo', 'imagen', 'descripcion', 'id_auditorio', 'editMode']);
        $this->successMessage = null;
    }

    public function updateEquipos()
    {
        $this->equipos = Equipo::all();
    }

    public function render()
    {
        return view('livewire.equipos');
    }
}
