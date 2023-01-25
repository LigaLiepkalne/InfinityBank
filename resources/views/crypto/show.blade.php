<style>
    .grayed-out {
        color: gray;
    }

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
        display: flex;
        align-items: center;
    }

    ul, li, th {
        background-color: white;
    }

    .col-md-6 {
    }
</style>

@include('userSettings.code-card')

<x-app-layout>
    <x-slot name="header">
        <a href="/trade"><h4> Back to main view</h4></a>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Trade') }}
        </h2>
    </x-slot>

    <main class="my-5">
        <div class="container">

            <section class="border-bottom pb-4 mb-5">
                <div class="row gx-5">

                    <div class="col-md-6 mb-4">
                        <div class="ripple shadow-2-strong rounded-5" data-mdb-ripple-color="light">
                            <ul class="list-group list-group-flush">

                                <li class="list-group-item d-flex align-items-center">
                                    <img src="{{ $crypto->getLogoURL() }}" alt="crypto-logo" width="50" height="50"
                                         style="margin-right: 5px;">
                                    <span class="crypto-name font-semibold text-xl"> {{ $crypto->getName() }} <span
                                            class="grayed-out">{{ $crypto->getSymbol() }}</span></span>

                                    <form method="GET" action="/trade/{{ $crypto->getSymbol() }}/show" id="formId"
                                          style="display: flex; align-items: center;" class="form-inline">
                                        <select name="currency"
                                                style="min-width: 100px; margin-left: 150px; margin-bottom: 10px"
                                                class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300
                    focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-5/6"
                                                name="currency">
                                            @foreach($currencies as $currency)
                                                <option value="{{ $currency }}" {{ $currency === 'EUR' ? 'selected' : '' }}>{{ $currency }}</option>
                                            @endforeach
                                        </select>
                                        <button type="submit" style="margin-left: 5px;  margin-bottom: 5px">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40"
                                                 fill="currentColor"
                                                 class="bi bi-arrow-right-square" viewBox="0 0 16 16" color="#cddade">
                                                <path fill-rule="evenodd"
                                                      d="M15 2a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2zM0 2a2 2 0 0 1
                          2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2zm4.5 5.5a.5.5 0 0 0 0 1h5.793l-2.147
                          2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z"/>
                                            </svg>
                                        </button>
                                    </form>
                                </li>

                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th class="fw-bold text-center">Current price</th>
                                        <th class="fw-bold text-center">Price change 1h</th>
                                        <th class="fw-bold  text-center">Price change 24h</th>
                                        <th class="fw-bold text-center">Price change 7d</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr class="fw-bold text-center">
                                        <td style="white-space: nowrap;"> {{ $crypto->getCurrency() }} {{ number_format($crypto->getPrice(), 2) }}</td>
                                        @if($crypto->getPercentChange1h() >= 0)
                                            <td class="text-success">
                                                <i class="fas fa-caret-up me-1"></i>{{ number_format($crypto->getPercentChange1h(), 2) }} %
                                            </td>
                                        @else
                                            <td class="text-danger">
                                                <i class="fas fa-caret-down me-1"></i> {{ number_format($crypto->getPercentChange1h(), 2) }} %
                                            </td>
                                        @endif
                                        @if($crypto->getPercentChange24h() >= 0)
                                            <td class="text-success">
                                                <i class="fas fa-caret-up me-1"></i> {{ number_format($crypto->getPercentChange24h(), 2) }} %
                                            </td>
                                        @else
                                            <td class="text-danger">
                                                <i class="fas fa-caret-down me-1"></i> {{ number_format($crypto->getPercentChange24h(), 2) }} %
                                            </td>
                                        @endif
                                        @if($crypto->getPercentChange7d() >= 0)
                                            <td class="text-success">
                                                <i class="fas fa-caret-up me-1"></i> {{ number_format($crypto->getPercentChange7d(), 2) }} %
                                            </td>
                                        @else
                                            <td class="text-danger">
                                                <i class="fas fa-caret-down me-1"></i> {{ number_format($crypto->getPercentChange7d(), 2) }} %
                                            </td>
                                        @endif
                                    </tr>
                                    </tbody>
                                </table>

                                <li class="list-group-item d-flex align-items-center"
                                    style="padding-top: unset; text-align: justify">
                                    <span> {{ $metadata[0] }}</span>
                                </li>

                                @foreach(array_slice($metadata, 2, 5) as $data)
                                    <li class="list-group-item d-flex align-items-center">
                                        <a href="{{ $data }}" target="_blank"><span> {{ $data }}</span></a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <form id="buy-sell-form" method="POST" action="">
                            @if (session('success'))
                                <div class="mx-auto text-center font-medium text-green-600" style="margin-top: 5px">
                                    {{ session('success') }}
                                </div>
                            @endif
                            <x-buy-sell-errors :errors="$errors"/>
                            @csrf
                            <div class="form-group mt-4">
                                <x-label for="amount">Amount<span style="color: red;">*</span></x-label>
                                <x-input id="amount" class="block mt-1 w-full" type="text" name="amount"
                                         :value="old('label')" required autofocus/>
                            </div>
                            <!-- Account-->
                            <div class="form-group">
                                <x-label for="account" class="w-1/6">Account<span style="color: red;">*</span></x-label>
                                <select style="color: #2563eb; display: inline-block; max-width: 350px;"
                                        name="account" id="account"
                                        class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300
                    focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1"
                                        required autofocus>
                                    <option selected>Select your account number</option>
                                    @foreach ($userBankAccounts as $index => $account)
                                        <option value="{{ $account->id }}"
                                                data-balance="{{ $account->balance }}"
                                                data-currency="{{ $account->currency }}">
                                            {{ $account->number }}  {{ $account->balance }} {{ $account->currency }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- Password-->
                            <div class="form-group">
                                <x-label for="password">Password <span style="color: red;">*</span></x-label>
                                <x-input id="password" class="block mt-1 w-full" type="password" name="password"
                                         required autofocus/>
                            </div>
                            <!-- Security code-->
                            <div class="form-group">
                                <x-label for="code">Security code No. {{ $codeIndex }}<span style="color: red;">*</span>
                                </x-label>
                                <x-input type="text" id="code" class="block mt-1 w-5/6" name="code" required autofocus/>
                                <input type="hidden" name="code_index" value="{{ $codeIndex }}">
                            </div>
                            <!-- Buttons-->
                            <div style="display: inline-flex; justify-content: center; align-items: center">
                                <div class="flex items-center justify-end mt-4">
                                    <x-button class="buy-btn ml-4"
                                              style="background-color: #7cbf72; border-radius: 30px">
                                        <b>{{ __('Buy') }}</b>
                                    </x-button>
                                </div>
                                <div class="flex items-center justify-end mt-4">
                                    <x-button class="sell-btn ml-4"
                                              style="background-color: #f97575; border-radius: 30px">
                                        <b> {{ __('Sell') }}</b>
                                    </x-button>
                                </div>
                            </div>
                        </form>

                        <script>
                            $(document).ready(function () {
                                $('#password').hide();
                                $('#code').hide();

                                $('label[for="password"]').hide();
                                $('label[for="code"]').hide();

                                $('#account').on('change', function () {
                                    var selectedOptionValue = $(this).find(':selected').val();

                                    if (selectedOptionValue !== "Select your account number") {
                                        $('#password').show();
                                        $('#code').show();

                                        $('label[for="password"]').show();
                                        $('label[for="code"]').show();
                                    } else {
                                        $('#password').hide();
                                        $('#code').hide();

                                        $('label[for="password"]').hide();
                                        $('label[for="code"]').hide();
                                    }
                                });
                            });
                        </script>

                        <script>
                            const form = document.getElementById('buy-sell-form');
                            const buyBtn = document.querySelector('.buy-btn');
                            const sellBtn = document.querySelector('.sell-btn');

                            buyBtn.addEventListener('click', function (event) {
                                event.preventDefault();
                                form.action = '/trade/{{ $crypto->getSymbol() }}/buy';
                                form.submit();
                            });

                            sellBtn.addEventListener('click', function (event) {
                                event.preventDefault();
                                form.action = '/trade/{{ $crypto->getSymbol() }}/sell';
                                form.submit();
                            });
                        </script>
                    </div>
                </div>
            </section>
</x-app-layout>
