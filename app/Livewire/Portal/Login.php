<?php

namespace App\Livewire\Portal;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{
    public string $email    = '';
    public string $password = '';
    public bool   $remember = false;

    protected array $rules = [
        'email'    => 'required|email',
        'password' => 'required',
    ];

    protected array $messages = [
        'email.required'    => 'Please enter your email address.',
        'email.email'       => 'Please enter a valid email address.',
        'password.required' => 'Please enter your password.',
    ];

    public function login(): void
    {
        $this->validate();

        if (!Auth::guard('hospital')->attempt(
            ['email' => $this->email, 'password' => $this->password],
            $this->remember
        )) {
            $this->password = '';
            $this->addError('email', 'Invalid email or password. Please try again.');
            return;
        }

        session()->regenerate();

        $hospital = Auth::guard('hospital')->user();

        $this->redirect(match($hospital->application_step) {
            'step2'     => route('portal.apply.step2'),
            'step3'     => route('portal.apply.step3'),
            default     => route('portal.dashboard'),
        }, navigate: true);
    }

    public function render()
    {
        return view('livewire.auth.login')
            ->layout('layouts.portal', ['title' => 'Hospital Portal Sign In']);
    }
}
