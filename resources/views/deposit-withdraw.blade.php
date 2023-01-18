<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('deposit-withdraw') }}">  <!-- Need to Change to only depost? -->
            @csrf

            <!-- Deposit Amount -->
            <div class="mt-4">
                <x-label for="amount" :value="__('Amount')" />
                <x-input id="amount" class="block mt-1 w-full" type="text" name="amount" :value="old('amount')" required autofocus />
            </div>
            <!-- Choose bank account -->
            <div class="mt-4">
                <x-label for="account" :value="__('Choose bank account')" />  <!-- Similar logit to sending to another user, here i need to speficy not user email but account -->
                <select class="block mt-1 w-full" name="account" id="account">
                    @foreach($userBankAccounts as $bankAccount)
                    <option value="account">{{ $bankAccount->number }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />

                <x-input id="password" class="block mt-1 w-full"
                         type="password"
                         name="password"
                         required autocomplete="current-password" />
            </div>

            <!-- Code card request -->
            <div class="mt-4">
                <x-label for="code" :value="__('Enter [4] code from your code card ')" />  <!-- Similar logit to sending to another user, here i need to speficy not user email but account -->
                <x-input id="code" class="block mt-1 w-full" type="text" name="code" :value="old('code')" required autofocus />
            </div>

            <!--Submit button -->
            <div class="flex items-center justify-end mt-4">
                <x-button class="ml-3">
                    {{ __('Deposit') }}
                </x-button>
            </div>
        </form>

        <a href="/dashboard">Back</a>

    </x-auth-card>
</x-guest-layout>
