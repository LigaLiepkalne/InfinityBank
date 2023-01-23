<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <img id="featured-image" src="../pngwing.com.png" class="w-30 h-20 fill-current text-gray-500" alt=""/>
            </a>
        </x-slot>

        <!-- MDB -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.1.0/mdb.min.css" rel="stylesheet"/>

        <div class="mb-4 text-sm text-gray-600">
            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <div class="flex items-center justify-end mt-4">
                <button class="ml-4 btn btn-dark btn-rounded btn-primary">
                    <b> {{ __('Email Password Reset Link') }}</b>
                </button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
