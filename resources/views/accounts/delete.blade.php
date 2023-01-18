<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Close an account
        </h2>
    </x-slot>

    <style>
        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 20px;
            margin-bottom: auto;

        }
        .form-group {
            display: flex;
            align-items: center;
        }

        .form-group label {
            width: 100px;

        }

        .form-group input,
        .form-group select {
            flex: 1;
        }
    </style>

    @if (session('success'))
        <div class="mx-auto text-center font-medium text-green-600" style="margin-top: 5px">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="/trade/{symbol}/create">

        @csrf

        <div class="form-group">
            <!-- Label -->
            <x-label for="label">
                Label
            </x-label>

            <x-input id="label" class="block mt-1 w-full" type="text" name="label" :value="old('label')" required autofocus />
        </div>

        <div class="form-group  mt-4">
            <!-- Type -->
            <x-label for="type">
                Account Type
            </x-label>

            <select name="type" id="type" style="width: 235px" required class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-5/6">
                <option value="checking">Checking</option>
                <option value="savings">Savings</option>
            </select>
        </div>



        <div class="form-group mt-4" style="display: flex; flex-direction: row; align-items: center;">

            <!-- Balance -->
            <x-label for="balance">
                Balance <span style="color: red;">*</span>
            </x-label>
            <x-input id="balance" class="block mt-1 w-full" style="width: 140px; margin-right: 5px" type="text" name="balance" :value="old('balance')" required />


        </div>



        <div class="form-group mt-4">
            <!-- Password -->
            <x-label for="password">
                Confirm with password <span style="color: red;">*</span>
            </x-label>
            <x-input id="password" class="block mt-1 w-full"
                     type="password"
                     name="password"
                     required autocomplete="new-password" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-button class="ml-4">
                {{ __('Open Account') }}
            </x-button>
        </div>
    </form>


</x-app-layout>
