
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

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

<!-- MDB -->
<script
    type="text/javascript"
    src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.1.0/mdb.min.js"></script>

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

    td, th, tr {
        text-align: center;
        border-color: transparent;
    }

    table {
        margin: 0 auto;
    }

    .table-info {
        text-align: center;
        padding-left: 110px ;
        min-block-size: 10px;
    }

    </style>
<div class="table-info bg-white max-w-8xl" >
    <h5 class="font-semibold"> {{$user->name}} {{$user->surname}}</h5>
    <h5 class="font-semibold"> {{$userBankAccount->number}} {{$userBankAccount->label}}</h5>
    <h5 class="font-semibold">Period: {{ $currentMonthStart->format('d.m.Y') }} - {{ $currentMonthEnd->format('d.m.Y') }}</h5>
</div>


<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">

                <div class="table-wrapper-scroll-y my-custom-scrollbar">
                    <table class="table align-middle mb-0 bg-white table-hover" >
                        <thead class="bg-light">
                        <tr>
                            <th ></th>
                            <th>Date</th>
                            <th>Paid to/Received from</th>
                            <th>Details</th>
                            <th>Amount</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($currentMonthTransactions as $transaction)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="ms-3">
                                            <p class="fw-bold mb-1">{{$loop->index + 1}}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="ms-3">
                                            <p class="fw-bold mb-1"> {{ date("d.m.Y", strtotime( $transaction->created_at)) }}</p>
                                        </div>
                                    </div>
                                </td>
                                @if($transaction->type === 'Outgoing Payment')
                                    <td>
                                        <p class="fw-normal mb-1">{{ $transaction->recipient_name }} {{ $transaction->recipient_surname }}</p>
                                        <p class="text-muted mb-0">{{ $transaction->recipient_account}}</p>
                                    </td>
                                    <td>
                                        <p class="fw-normal mb-1">{{ $transaction->details }}</p>
                                        <p class="text-muted mb-0">{{ $transaction->received_amount }}, {{ $transaction->sent_currency }}</p>
                                        <p class="text-muted mb-0">EXCHANGE RATE: {{ $transaction->conversion_rate }}</p>
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
                                        <p class="text-muted mb-0">{{ $transaction->sent_amount }}, {{ $transaction->received_currency }}</p>
                                        <p class="text-muted mb-0">EXCHANGE RATE:{{ $transaction->conversion_rate }}</p>
                                    </td>
                                    <td>
                                        <p class="text-success mb-0">+{{ $transaction->received_amount }} {{$userBankAccount->currency}}</p>
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

<div class="table-info bg-transparent max-w-8xl text-center" style="margin-top: 10px">
    <h4> {{$userBankAccount->currency}} Closing balance {{ date("d.m.Y") }} <span class="font-semibold">{{$userBankAccount->balance}}</span></h4>
    <p>Debit Turnover <span class="text-danger"> {{ $debit }}</span> {{$userBankAccount->currency}}</p>
    <p>Credit Turnover<span class="text-success"> +{{ $credit }} </span> {{$userBankAccount->currency}}</p>
</div>



