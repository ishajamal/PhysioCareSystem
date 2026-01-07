<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use App\Models\User;

class Register extends Component
{
    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';
    public $phoneNumber = '';
    public $showPassword = false;
    public $showConfirmPassword = false;


    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
        'phoneNumber' => 'nullable|string|max:20',
    ];

    protected $messages = [
        'password.min' => 'Password must be at least 8 characters',
        'password.confirmed' => 'Passwords do not match',
        'email.unique' => 'This email is already registered',
    ];

    public function register()
    {
        $this->validate();


        // Create the user - ALWAYS as therapist
        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => bcrypt($this->password),
            'role' => 'therapist', // ← FIXED as therapist
            'phoneNumber' => $this->phoneNumber ?: null,
            // profileImage is nullable, will be null by default
        ]);
        dd($user);

        session()->flash('success', 'Registration successful! Please login.');
        return redirect()->route('login');
    }

    public function togglePasswordVisibility()
    {
        $this->showPassword = !$this->showPassword;
    }

    public function toggleConfirmPasswordVisibility()
    {
        $this->showConfirmPassword = !$this->showConfirmPassword;
    }

    public function render()
    {
        return view('livewire.auth.register');
    }
}