<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.1.0/mdb.min.css" rel="stylesheet"/>

<x-app-layout>
    @include('userSettings.code-card')

    <style>
        body {
            background-color: hsl(0, 0%, 94%)
        }

        label {
            width: 100%;
        }

        .card-input-element {
            display: none;
        }

        .card-input:hover {
            cursor: pointer;
            background-color: hsl(144, 60%, 95.9%);
            -webkit-transition: 0.5s;
            -o-transition: 0.5s;
            transition: 0.5s;
        }

        .card-input-element:checked + .card-input {
            border: 1px solid hsl(144, 100%, 35.9%);
        }

        .icon-color {
            color: #30464a; /* red color */
        }

        h1 {
            color: #bccacf;
        }
    </style>

    <x-slot name="header">
        <h1 class="font-semibold text-xxl text-center leading-tight bg-green-100">{{ __('Dashboard') }}</h1>
    </x-slot>

    @if (session('success'))
        <div class="mx-auto text-center font-medium text-green-600" style="margin-top: 15px">
            {{ session('success') }}
        </div>
    @endif

    <div class="container my-5">

        <section class="p-1 z-depth-1 mb-0">
            <div class="row d-flex justify-content-center md:border-t-0">
                <div class="col-md-6 col-lg-3 text-center">
                    <h4 class="h1 font-weight-bold mb-3">
                        <i class="fas fa-piggy-bank icon-color"></i>
                        <span class="d-inline-block count-up" data-from="0" data-to="100"
                              data-time="2000">{{ number_format($totalBalance, 2) }}</span>
                    </h4>
                    <p class="font-weight-normal text-muted">Total value in EUR</p>
                </div>
                <div class="col-md-6 col-lg-3 mb-4 text-center">
                    <h4 class="h1 font-weight-bold mb-3">
                        <i class="fas fa-money-check icon-color"></i>
                        <span class="d-inline-block count1" data-from="0" data-to="250"
                              data-time="2000">{{$userAccountCount}}</span>
                    </h4>
                    <p class="font-weight-normal text-muted">Accounts opened</p>
                </div>
                <div class="col-md-6 col-lg-3 mb-4 text-center">
                    <h4 class="h1 font-weight-bold mb-3">
                        <i class="fas fa-coins icon-color"></i>
                        <span class="d-inline-block count2" data-from="0" data-to="330"
                              data-time="2000">{{$userAccountCurrencyCount}}</span>
                    </h4>
                    <p class="font-weight-normal text-muted">Currencies</p>
                </div>
                <div class="col-md-6 col-lg-3 mb-4 text-center">
                    <h4 class="h1 font-weight-bold mb-3">
                        <i class="fab fa-bitcoin icon-color"></i>
                        <span class="d-inline-block count3" data-from="0" data-to="430" data-time="2000">{{$userCryptoPortfoliosCount}}</span>
                    </h4>
                    <p class="font-weight-normal text-muted">Crypto portfolios</p>
                </div>
            </div>
        </section>

        <hr class="my-3" style="background-color: hsl(0, 0%, 65%)"/>
        <div class="row gx-lg-5">
            @foreach ($userBankAccounts as $account)
                <div class="col-md-3 mb-4">
                    <label>
                        <input id="radioDefault1" type="radio" name="defaultGroup" class="card-input-element"/>
                        <div class="card card-input" onclick="location.href='accounts/{{ $account->id }}'"
                             style="cursor:pointer;">
                            <div class="card-body">
                                <p class="text-uppercase fw-bold text-muted" style="margin-bottom: auto">{{ $account->label }}</p>
                                <p class="text-sm font-extralight text-muted" style="margin-top: auto">{{ $account->number }}</p>
                                <p class="h3 fw-bold">{{ $account->balance }} {{ $account->currency }}</p>
                                <p class="mb-0 font-weight-normal text-muted">Created: {{ date("d.m.Y", strtotime($account->created_at)) }}</p>
                            </div>
                        </div>
                    </label>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
