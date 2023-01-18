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

     .crypto-inline{
         display: flex;
         align-items: center;
     }
</style>

@include('userSettings.code-card')
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Trade
        </h2>
    </x-slot>

    <form method="GET" action="/trade/{{ $crypto->getSymbol() }}/show" id="formId" style="display: flex; align-items: center; margin-top: 20px">
        <select name="currency" style="min-width: 100px; " required class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-5/6" name="currency" >
            @foreach($currencies as $currency)
                <option value="{{ $currency }}">{{ $currency }}</option>
            @endforeach
        </select>
        <button type="submit" style="margin-left: 5px; margin-top:5px;"><svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-arrow-right-square" viewBox="0 0 16 16" color="#cddade">
                <path fill-rule="evenodd" d="M15 2a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2zM0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2zm4.5 5.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z"/>
            </svg></button>

    </form>


    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg ">
        <div class="p-6 bg-white border-b border-gray-200">
            <table class="table table-hover text-nowrap">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Price</th>
                    <th scope="col">1h %</th>
                    <th scope="col">24h %</th>
                    <th scope="col">7d %</th>
                    <th scope="col">Market cap</th>
                    <th scope="col">Volume(24h)</th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody>

                    <tr>
                        <th scope="row"></th>
                        <td class="crypto-inline">
                                <img src="{{ $crypto->getLogoURL() }}" alt="crypto-logo" width="35" height="35">
                            <span class="crypto-name">{{ $crypto->getName() }}
                                <span class="grayed-out">{{ $crypto->getSymbol() }}</span></span>
                        </td>
                        <td> {{ $crypto->getCurrency() }} {{ number_format($crypto->getPrice(), 2) }}</td>
                        @if($crypto->getPercentChange1h() >= 0)
                            <td class="text-success"><i class="fas fa-caret-up me-1"></i>
                                {{ number_format($crypto->getPercentChange1h(), 2) }} %</td>
                        @else
                            <td class="text-danger"><i class="fas fa-caret-down me-1"></i> {{ number_format($crypto->getPercentChange1h(), 2) }} %</td>
                        @endif

                        @if($crypto->getPercentChange24h() >= 0)
                            <td class="text-success"><i class="fas fa-caret-up me-1"></i> {{ number_format($crypto->getPercentChange24h(), 2) }} %</td>
                        @else
                            <td class="text-danger"><i class="fas fa-caret-down me-1"></i> {{ number_format($crypto->getPercentChange24h(), 2) }} %</td>
                        @endif

                        @if($crypto->getPercentChange7d() >= 0)
                            <td class="text-success"><i class="fas fa-caret-up me-1"></i> {{ number_format($crypto->getPercentChange7d(), 2) }} %</td>
                        @else
                            <td class="text-danger"><i class="fas fa-caret-down me-1"></i> {{ number_format($crypto->getPercentChange7d(), 2) }} %</td>
                        @endif
                        <td>{{ $crypto->getCurrency() }} {{ number_format($crypto->getMarketCap(), 3) }}</td>
                        <td>{{ $crypto->getCurrency() }} {{ number_format($crypto->getvolume24h(), 3) }}</td>
                        <td>
                        </td>

                    </tr>
                </tbody>
            </table>

        </div>
    </div>


    <form id="buy-sell-form" method="POST" action="">


        @if (session('success'))
            <div class="mx-auto text-center font-medium text-green-600" style="margin-top: 5px">
                {{ session('success') }}
            </div>
        @endif

            <x-buy-sell-errors :errors="$errors" />

        @csrf

        <div class="form-group mt-4">
            <x-label for="amount">
                Amount
            </x-label>
            <x-input id="label" class="block mt-1 w-full" type="text" name="amount" :value="old('label')" required autofocus />
        </div>

        <!-- ACCOUNT-->
        <div class="form-group">
            <x-label for="account" class="w-1/6">
                Account<span style="color: red;">*</span>
            </x-label>

            <select style="color: #2563eb; display: inline-block; max-width: 350px;"
                    name="account" id="account"
                    class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1"
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
            <x-label for="password">
                Password <span style="color: red;">*</span>
            </x-label>
            <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autofocus/>
        </div>

        <!-- Security code-->
        <div class="form-group">
            <x-label for="code">
                Security code No. {{ $codeIndex }}<span style="color: red;">*</span>
            </x-label>
            <x-input type="text" id="code" class="block mt-1 w-5/6" name="code" required autofocus/>
            <input type="hidden" name="code_index" value="{{ $codeIndex }}">
        </div>

        <div style="display: inline-flex; justify-content: center; align-items: center">
            <div class="flex items-center justify-end mt-4">
                <x-button class="buy-btn ml-4" style="background-color: #73aa79;">
                    {{ __('Buy') }}
                </x-button>
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button class="sell-btn ml-4" style="background-color: #db7c7c;">
                    {{ __('Sell') }}
                </x-button>
            </div>
        </div>

    </form>

    <script>
        const form = document.getElementById('buy-sell-form');
        const buyBtn = document.querySelector('.buy-btn');
        const sellBtn = document.querySelector('.sell-btn');

        buyBtn.addEventListener('click', function(event) {
            event.preventDefault();
            form.action = '/trade/{{ $crypto->getSymbol() }}/buy';
            form.submit();
        });

        sellBtn.addEventListener('click', function(event) {
            event.preventDefault();
            form.action = '/trade/{{ $crypto->getSymbol() }}/sell';
            form.submit();
        });
    </script>

</x-app-layout>
