<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;

class Profile extends Component
{
    public User $user;
    public bool $isAdmin = false;
    public $users = []; // For admins to see all users
    public $admin = null; // For regular users to contact the admin

    public function mount()
    {
        $this->user = auth()->user();
        $this->isAdmin = $this->user->tipo_usuario === 'admin'; // Check if the user is an admin

        if ($this->isAdmin) {
            $this->users = User::all(); // Admin can see all users
        } else {
            $this->admin = User::where('tipo_usuario', 'admin')->first(); // Regular users see the admin
        }
    }

    public function render()
    {
        return view('livewire.profile');
    }
}
