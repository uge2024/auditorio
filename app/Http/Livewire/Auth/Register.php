<?php

namespace App\Http\Livewire\Auth;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class Register extends Component
{
    public $ci = '';
    public $first_name = '';
    public $last_name = '';
    public $address = '';
    public $number = '';
    public $unidad = '';
    public $email = '';
    public $password = '';
    public $passwordConfirmation = '';
    public $showSuccessModal = false; // Modal visibility

    public function mount()
    {
        if (auth()->user()) {
            return redirect()->intended('/dashboard');
        }
    }

    public function updated($field)
    {
        $this->validateOnly($field, $this->validationRules());
    }

    protected function validationRules()
    {
        return [
            'ci' => 'required|string|max:20|unique:users,ci|regex:/^\d+$/',
            'first_name' => 'required|string|max:50|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/',
            'last_name' => 'required|string|max:50|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/',
            'address' => 'required|string|max:100',
            'number' => 'required|numeric|digits_between:7,15',
            'unidad' => 'required|string|max:100|regex:/^[a-zA-Z0-9\s]+$/',
            'email' => 'required|email:rfc,dns|unique:users,email',
            'password' => [
                'required',
                'min:8',
                'regex:/[A-Z]/',       // At least one uppercase letter
                'regex:/[a-z]/',       // At least one lowercase letter
                'regex:/[0-9]/',       // At least one digit
                'same:passwordConfirmation'
            ],
        ];
    }

    public function register()
    {
        $this->validate($this->validationRules());

        User::create([
            'ci' => $this->ci,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'address' => $this->address,
            'number' => $this->number,
            'unidad' => $this->unidad,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'remember_token' => Str::random(10),
            'estatus' => 'inactivo',
            'tipo_usuario' => 'user',
        ]);

        // Display success message
        session()->flash('success', 'Tu cuenta ha sido creada exitosamente. Ahora puedes iniciar sesión.');
        return redirect('/login');
    }

    public function render()
    {
        return view('livewire.auth.register');
    }
}
