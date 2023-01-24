<style>
    .my-custom-scrollbar {
        position: relative;
        height: 600px;
        min-height: auto;
        overflow: auto;
        margin: auto;
    }

    .table-wrapper-scroll-y {
        display: block;
        max-width: 95%;
        width: 1700px;
        justify-items: center;
        margin: 0 auto;
    }

    td, th, tr {
        text-align: center;
        border-color: transparent;
    }

    form {
        margin: 0 auto;
        width: 50%;
        padding-bottom: 20px;
        padding-top: 10px;
    }

    .form-group {
        margin-inline: 5px;
    }

    h1 {
        color: #bccacf;
    }
</style>

@include('userSettings.code-card')

<x-app-layout>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.1.0/mdb.min.css" rel="stylesheet"/>
    <x-slot name="header">
        <h1 class="font-semibold text-xxl text-center leading-tight bg-green-100">
            Transaction history
        </h1>
    </x-slot>
    <form class="mb-2 mt-4 text-center d-flex justify-content-center" method="GET"
          action="{{ route('crypto-transactions.index') }}">
        <!-- Select account-->
        <div class="form-group" style="margin-top: 20px;">
            <select style="color: #2563eb; display: inline-block; margin-left:25px; margin-right: 10px;" name="account"
                    id="account"
                    class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300
                    focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-5/6"
                    required autofocus>
                <option selected>Select your account number</option>
                @foreach ($userBankAccounts as $index => $account)
                    <option value="{{ $account->number }}">{{ $account->number }}</option>
                @endforeach
            </select>
        </div>
        <!-- Date inputs-->
        <div class="form-group">
            <x-label for="start-date">Start Date</x-label>
            <x-input type="date" name="start-date" id="start-date" class="form-control datepicker"
                     min="{{ date('Y-m-d', strtotime('-1 year')) }}" max="{{ date('Y-m-d', strtotime('+1 day')) }}"/>
        </div>
        <div class="form-group">
            <x-label for="end-date">End Date</x-label>
            <x-input type="date" name="end-date" id="end-date" class="form-control datepicker"
                     min="{{ date('Y-m-d', strtotime('-1 year')) }}" max="{{ date('Y-m-d', strtotime('+1 day')) }}"/>
        </div>
        <div class="form-group text-center" style="margin-top: 28px">
            <button class="ml-4 btn btn-rounded btn-primary" style="background-color: #95b2b9">
                <b> {{ __('Filter') }}</b>
            </button>
        </div>
    </form>

    <div class="py-1">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <div class="table-wrapper-scroll-y my-custom-scrollbar">
                        <table class="table align-middle mb-0 bg-white table-hover">
                            <thead class="bg-light">
                            <tr>
                                <th></th>
                                <th class="fw-bold mb-1">Date</th>
                                <th class="fw-bold mb-1">Currency</th>
                                <th class="fw-bold mb-1">Price</th>
                                <th class="fw-bold mb-1">Details</th>
                                <th class="fw-bold mb-1">Amount</th>
                                <th class="fw-bold mb-1">Total</th>
                                <th class="fw-bold mb-1">Profit/Loss</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($transactions as $transaction)
                                <tr>
                                    <td>
                                        <p class="fw-normal mb-1">{{$loop->index + 1}}</p>
                                    </td>
                                    <td>
                                        <p class="fw-normal mb-1"> {{ date("d.m.Y", strtotime( $transaction->created_at)) }}</p>
                                    </td>
                                    <td>
                                        <p class="fw-normal mb-1">{{ $transaction->symbol }}</p>
                                    </td>
                                    <td>
                                        <p class="fw-normal mb-1">{{ $transaction->price }}</p>
                                    </td>
                                    <td>
                                        <p class="fw-normal mb-1">{{ $transaction->type }}</p>
                                    </td>
                                    <td>
                                        <p class="fw-normal mb-1">
                                            @if(substr($transaction->amount, -4) == "00000")
                                                {{ number_format($transaction->amount, 2) }}
                                            @else
                                                {{ rtrim(number_format($transaction->amount, 4, '.', ''), '0') }}
                                            @endif
                                        </p>
                                    </td>
                                    <td>
                                        <p class="fw-normal mb-1">{{ $transaction->total }}</p>
                                    </td>
                                    @if($transaction->profit_loss !== null && $transaction->profit_loss >= 0)
                                        <td>
                                            <p class="text-success mb-0">+{{ $transaction->profit_loss }} </p>
                                        </td>
                                    @else
                                        <td>
                                            <p class="text-danger mb-0">{{ $transaction->profit_loss }} </p>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
