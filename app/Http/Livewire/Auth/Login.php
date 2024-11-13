<?php

namespace App\Http\Livewire\Auth;

use App\Models\User;
use Livewire\Component;

class Login extends Component
{
    public $email = '';
    public $password = '';
    public $remember_me = false;
    public $activationError = ''; // Add this line

    protected $rules = [
        'email' => 'required|email:rfc,dns',
        'password' => 'required|min:6',
    ];

    public function mount()
    {
        if (auth()->user()) {
            return redirect()->intended('/dashboard');
        }
    }

    public function login()
    {
        $credentials = $this->validate();

        // Buscar usuario por email
        $user = User::where('email', $this->email)->first();

        // Verificar si el usuario está inactivo
        if ($user && $user->estatus === 'inactivo') {
            $this->activationError = 'Tu cuenta está inactiva. Comunícate con la unidad responsable.'; // Update this line
            return;
        }

        // Intentar autenticación si el usuario está activo
        if (auth()->attempt(['email' => $this->email, 'password' => $this->password], $this->remember_me)) {
            auth()->login($user, $this->remember_me);
            return redirect()->intended('/dashboard');
        } else {
            return $this->addError('email', trans('auth.failed'));
        }
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}