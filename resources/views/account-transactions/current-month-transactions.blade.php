<style>
    .my-custom-scrollbar {
        position: relative;
        height: 400px;
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

    table {
        margin: 0 auto;
    }

    .table-info {
        padding-left: 110px;
        min-block-size: 10px;
    }
</style>

<div class="table-info bg-white max-w-8xl">
    <h5 class="font-semibold">Period: {{ $currentMonthStart->format('d.m.Y') }}
        - {{ $currentMonthEnd->format('d.m.Y') }}</h5>
</div>

<div class="py-1">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-1 bg-white border-b border-gray-200">

                <div class="table-wrapper-scroll-y my-custom-scrollbar">
                    <table class="table mb-0 bg-white table-hover">
                        <thead class="bg-light">
                        <tr>
                            <th></th>
                            <th class="fw-bold mb-1">Date</th>
                            <th class="fw-bold mb-1">Paid to/Received from</th>
                            <th class="fw-bold mb-1">Details</th>
                            <th class="fw-bold mb-1">Amount</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($currentMonthTransactions as $transaction)
                            <tr>
                                <td>
                                    <p class="fw-normal mb-1">{{$loop->index + 1}}</p>
                                </td>
                                <td>
                                    <p class="fw-normal mb-1"> {{ date("d.m.Y", strtotime($transaction->created_at)) }}</p>
                                </td>
                                @if($transaction->type === 'Outgoing Payment')
                                    <td>
                                        <p class="fw-normal mb-1">{{ $transaction->recipient_name }} {{ $transaction->recipient_surname }}</p>
                                        <p class="text-muted mb-0">{{ $transaction->recipient_account}}</p>
                                    </td>
                                    <td>
                                        <p class="fw-normal mb-1">{{ $transaction->details }}</p>
                                        <p class="text-muted mb-0">{{ $transaction->received_amount }}
                                            , {{ $transaction->sent_currency }}</p>
                                        <p class="text-muted mb-0">EXCHANGE
                                            RATE: {{ $transaction->conversion_rate }}</p>
                                    </td>
                                    <td>
                                        <p class="text-danger mb-0">{{ $transaction->sent_amount }} {{$userBankAccount->currency}} </p>
                                    </td>
                                @else
                                    <td>
                                        <p class="fw-normal mb-1">{{ $transaction->sender_name }} {{ $transaction->sender_surname }}</p>
                                        <p class="text-muted mb-0">{{ $transaction->sender_account}}</p>
                                    </td>
                                    <td>
                                        <p class="fw-normal mb-1">{{ $transaction->details }}</p>
                                        <p class="text-muted mb-0">{{ $transaction->sent_amount }}
                                            , {{ $transaction->received_currency }}</p>
                                        <p class="text-muted mb-0">EXCHANGE RATE:{{ $transaction->conversion_rate }}</p>
                                    </td>
                                    <td>
                                        <p class="text-success mb-0">
                                            +{{ $transaction->received_amount }} {{$userBankAccount->currency}}</p>
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

<div class="table-info bg-transparent max-w-8xl" style="margin-top: 10px;">
    <h5> Closing balance {{ date("d.m.Y") }}
        <span class="font-semibold"><b>{{$userBankAccount->balance}} {{$userBankAccount->currency}}</b></span>
    </h5>
    <p>Debit turnover <span class="text-danger"> {{ $debit }} </span>{{$userBankAccount->currency}}</p>
    <p>Credit turnover<span class="text-success"> +{{ $credit }} </span> {{$userBankAccount->currency}}</p>
</div>
