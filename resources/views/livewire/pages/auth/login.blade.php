<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new class extends Component
{
    public LoginForm $form;


    // Validation rules
    protected $rules = [
        'form.email' => 'required|email',
        'form.password' => 'required|min:6',
    ];

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('/', absolute: false), navigate: true);
    }
}; 
?>
<div class="flex justify-center">
    <div class="p-4 bg-white shadow-lg rounded">
        <!-- Session Status -->
        <x-auth-session-status :status="session('status')" />

        <form wire:submit="login">
            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input wire:model="form.email" id="email" type="email" name="email" required autofocus autocomplete="username" class="w-full"/>
                <x-input-error :messages="$errors->get('form.email')" />
            </div>

            <!-- Password -->
            <div>
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input wire:model="form.password" id="password" type="password" name="password" required autocomplete="current-password" class="w-full"/>
                <x-input-error :messages="$errors->get('form.password')" />
            </div>

            <!-- Remember Me and Forgot Password -->
            <div class="flex space-x-4">
                <div>
                    <label for="remember">
                        <input wire:model="form.remember" id="remember" type="checkbox" name="remember">
                        <span class="text-s">{{ __('Remember me') }}</span>
                    </label>
                </div>
                <div>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" wire:navigate class="text-s">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif
                </div>
            </div>

            <div class="flex justify-between w-full">
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="self-start">
                        {{ __('Register') }}
                    </a>
                @endif

                <x-primary-button class="ml-auto self-end">
                    {{ __('Log in') }}
                </x-primary-button>
            </div>


        </form>
    </div>
</div>
