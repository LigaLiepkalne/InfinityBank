
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<!-- MDB -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.1.0/mdb.min.css" rel="stylesheet"/>


<x-app-layout>

    <x-slot name="header">
        <h1 class="font-semibold text-xxl text-center leading-tight bg-green-100">
            Open an account
        </h1>
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

        h1 {
            font-size: 2.5rem;
            font-weight: 600;
            line-height: 1.2;
            color: #bccacf;
        }
    </style>

    @if (session('success'))
        <div class="mx-auto text-center font-medium text-green-600" style="margin-top: 5px">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('accounts.create') }}">
        <x-create-account-errors :errors="$errors" />

        @csrf

        <div class="form-group">
            <!-- Label -->
            <x-label for="label">
                Label
            </x-label>

            <x-input id="label" class="block mt-1 w-full" type="text" name="label" :value="old('label')" autofocus />
        </div>

        <div class="form-group mt-2" style="display: flex; flex-direction: row; align-items: center;">

            <!-- Balance -->
            <x-label for="balance">
                Balance <span style="color: red;">*</span>
            </x-label>
            <x-input id="balance" class="block mt-1 w-full" style="width: 135px; margin-right: 5px" type="text" name="balance" :value="old('balance')" required />

            <div class="form-group">
            <!-- Currency -->
            <select id="currency" style="width: 95px" required class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-5/6" name="currency" required>
                @foreach($currencies as $currency)
                    <option value="{{ $currency }}">{{ $currency }}</option>
                @endforeach
            </select>
            </div>
        </div>



        <div class="form-group mt-2">
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
            <button class="ml-4 btn btn-dark btn-rounded btn-primary">
                <b> {{ __('Open Account') }}</b>
            </button>
        </div>
    </form>

</x-app-layout>


