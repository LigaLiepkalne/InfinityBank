
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
    <h5 class="font-semibold"> Total Portfolio value: {{$cryptoPortfolioValue}} {{$userBankAccount->currency}}</h5>
    @if ($totalProfitLoss > 0)
    <h5 class="text-success mb-0"> Total Profit/Loss: {{  number_format($totalProfitLoss, 2) }} {{$userBankAccount->currency}}</h5>
    @else
    <h5 class="text-danger mb-0"> Total Profit/Loss: {{ number_format($totalProfitLoss, 2) }} {{$userBankAccount->currency}}</h5>
    @endif
</div>

<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">

                <div class="table-wrapper-scroll-y my-custom-scrollbar">
                    <table class="table align-middle mb-0 bg-white table-hover" >
                        <thead class="bg-light">
                        <tr>
                            <th ></th>
                            <th>Crypto</th>
                            <th>Average buying price</th>
                            <th>Current price</th>
                            <th>Total value</th>
                            <th>Total amount</th>
                            <th>Profit/Loss</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($cryptoPortfolio as $key => $portfolio)
                            <tr>
                                <td>
                                    <p class="fw-bold mb-1">{{$loop->index + 1}}</p>
                                </td>
                                <td>
                                    <p class="fw-normal mb-1">{{ $portfolio->symbol }}</p>
                                </td>
                                <td>
                                    <p class="fw-normal mb-1">{{ $portfolio->avg_price }} {{ $userBankAccount->currency }}</p>
                                </td>
                                <td>
                                    <p class="fw-normal mb-1">{{ number_format($cryptoCurrentPrice[$key], 2) }} {{ $userBankAccount->currency }}</p>
                                </td>
                                <td>
                                    <p class="fw-normal mb-1">{{ $portfolio->total }} {{ $userBankAccount->currency }}</p>
                                </td>
                                <td>
                                    <p class="fw-normal mb-1">{{ $portfolio->amount }}</p>
                                </td>
                                <td>
                                    @if( number_format(($cryptoCurrentPrice[$key] * $portfolio->amount) -
                                         ($portfolio->avg_price * $portfolio->amount), 2) > 0)
                                    <p class="text-success mb-0">
                                        {{ number_format(($cryptoCurrentPrice[$key] * $portfolio->amount) -
                                         ($portfolio->avg_price * $portfolio->amount), 2) }} {{ $userBankAccount->currency }}</p>
                                    @else
                                        <p class="text-danger mb-0">
                                            {{ number_format(($cryptoCurrentPrice[$key] * $portfolio->amount) -
                                         ($portfolio->avg_price * $portfolio->amount), 2) }} {{ $userBankAccount->currency }}</p>
                                    @endif
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
