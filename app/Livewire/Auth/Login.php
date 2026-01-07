<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('livewire.auth.login')]
class Login extends Component
{
    public $id = '';
    public $password = '';

    
    // protected $rules = [
    //     'id' => 'required|string',
    //     'password' => 'required|string|min:6',
    // ];

    // protected $messages = [
    //     'id.required' => 'Please enter your ID',
    //     'password.required' => 'Please enter your password',
    //     'password.min' => 'Password must be at least 6 characters',
    // ];

    public function login()
    {
        dd([
            'id' => $this->id,
            'password' => $this->password,
            'validation_passed' => true,
        ]);

        $this->validate();

        // Attempt login using 'email' field in database
        if (Auth::attempt(['email' => $this->id, 'password' => $this->password])) {
            session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        // If login fails
        session()->flash('error', 'Invalid credentials. Please try again.');
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}