<!-- Font Awesome -->
<link
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
    rel="stylesheet"
/>
<!-- Google Fonts -->
<link
    href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap"
    rel="stylesheet"
/>
<!-- MDB -->
<link
    href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.1.0/mdb.min.css"
    rel="stylesheet"
/>

<!-- import app.js -->
<script src="{{ asset('js/app.js') }}" defer></script>

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
        width: 450px;
    }

    .form-group label {
        width: 100px;

    }

    .form-group input,
    .form-group select {
        flex: 1;
    }

    .form-inline {
        display: inline-block;

    }
</style>

    <form method="POST" action="/trade/{{ $crypto->getSymbol() }}/sell" class="form-inline">
        <x-create-account-errors :errors="$errors" />
        @csrf

        <div class="form-group mt-4">
            <x-input id="label" class="block mt-1 w-full" type="text" name="amount" :value="old('label')" placeholder="Amount" required autofocus />
        </div>

        <!-- ACCOUNT-->
        <div class="form-group">

            <select style="color: #2563eb; display: inline-block;"
                    name="account" id="account"
                    class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-5/6"
                    required autofocus>
                @foreach ($userBankAccounts as $index => $account)
                    <option value="{{ $account->id }}"
                            data-balance="{{ $account->balance }}"
                            data-currency="{{ $account->currency }}"
                            @if ($index === 0) selected @endif>
                        {{ $account->number }}  {{ $account->balance }} {{ $account->currency }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- PASSWORD-->
        <div class="form-group">
            <x-input id="password" class="block mt-1 w-full" type="text" name="password" placeholder="Password" required autofocus/>
        </div>

        <!-- Security code-->
        <div class="form-group">
            <x-input type="text" id="code" class="block mt-1 w-5/6" name="code" placeholder="Security code No. {{ $codeIndex }}" required autofocus/>
            <input type="hidden" name="code_index" value="{{ $codeIndex }}">
        </div>

        <div style="display: inline-flex; justify-content: center; align-items: center">
            <div class="flex items-center justify-end mt-4">
                <x-button class="ml-4" style="background-color: #db7c7c;">
                    {{ __('Sell') }}
                </x-button>
            </div>
        </div>
    </form>

