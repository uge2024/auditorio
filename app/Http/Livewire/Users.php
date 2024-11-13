<?php
namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class Users extends Component
{
    use WithPagination;

    public $search = '';
    public $filterStatus = '';
    public $isUserModalOpen = false;
    public $userId;
    public $first_name, $last_name, $email, $password, $tipo_usuario, $estatus, $ci;

    public function getRules()
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->userId,
            'password' => 'nullable|string|min:8',
            'tipo_usuario' => 'required|in:admin,user',
            'estatus' => 'required|in:activo,inactivo',
            'ci' => 'nullable|string|max:20',  // Asegúrate de que el campo CI esté limitado a un tamaño adecuado
        ];
    }

    public function render()
    {
        $users = User::query()
            ->when($this->search, function ($query) {
                $query->where('first_name', 'like', '%' . $this->search . '%')
                    ->orWhere('last_name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->when($this->filterStatus, function ($query) {
                $query->where('estatus', $this->filterStatus);
            })
            ->paginate(10);

        return view('livewire.users', compact('users'));
    }

    public function openCreateUserModal()
    {
        $this->resetForm();
        $this->userId = null;
        $this->isUserModalOpen = true;
    }

    public function openEditUserModal($id)
    {
        $user = User::findOrFail($id);
        $this->userId = $id;
        $this->first_name = $user->first_name;
        $this->last_name = $user->last_name;
        $this->email = $user->email;
        $this->password = ''; // Mantener el campo de contraseña vacío
        $this->tipo_usuario = $user->tipo_usuario;
        $this->estatus = $user->estatus;
        $this->ci = $user->ci;
        $this->isUserModalOpen = true;
    }

    public function createUser()
    {
        $this->validate();

        User::create([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'tipo_usuario' => $this->tipo_usuario,
            'estatus' => $this->estatus,
            'ci' => $this->ci,
        ]);

        $this->resetForm();
        $this->isUserModalOpen = false;
        session()->flash('message', 'Usuario creado exitosamente.');
    }

    public function updateUser()
    {
        $this->validate();

        $user = User::findOrFail($this->userId);

        $user->update([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'password' => $this->password ? Hash::make($this->password) : $user->password,
            'tipo_usuario' => $this->tipo_usuario,
            'estatus' => $this->estatus,
            'ci' => $this->ci,
        ]);

        $this->resetForm();
        $this->isUserModalOpen = false;
        session()->flash('message', 'Usuario actualizado exitosamente.');
    }

    public function deleteUser($id)
    {
        User::findOrFail($id)->delete();
        session()->flash('message', 'Usuario eliminado exitosamente.');
    }

    public function changeStatus($id, $status)
    {
        $user = User::findOrFail($id);
        $user->estatus = $status;
        $user->save();
        session()->flash('message', 'Estado del usuario actualizado exitosamente.');
    }

    private function resetForm()
    {
        $this->first_name = '';
        $this->last_name = '';
        $this->email = '';
        $this->password = '';
        $this->tipo_usuario = 'user';
        $this->estatus = 'activo';
        $this->ci = '';
    }
}