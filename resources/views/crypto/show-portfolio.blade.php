<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
      crossorigin="anonymous">

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>

<link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.1.0/mdb.min.css" rel="stylesheet"/>

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
        border-color: transparent;
    }

    table {
        margin: 0 auto;
    }

    .table-info {
        text-align: center;
        min-block-size: 10px;
    }

</style>

<div class="table-info bg-white max-w-8xl">
    <h5 class="font-semibold"> Total Portfolio
        value: {{  number_format($cryptoPortfolioValue, 2) }} {{$userBankAccount->currency}}</h5>
    @if ($totalProfitLoss > 0)
        <h5 class="text-success mb-0"> Total
            Profit/Loss: {{  number_format($totalProfitLoss, 2) }} {{$userBankAccount->currency}}</h5>
    @else
        <h5 class="text-danger mb-0"> Total
            Profit/Loss: {{ number_format($totalProfitLoss, 2) }} {{$userBankAccount->currency}}</h5>
    @endif
</div>

<div class="py-1">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-2 bg-white border-b border-gray-200">

                <div class="table-wrapper-scroll-y my-custom-scrollbar">
                    <table class="table mb-0 bg-white table-hover">
                        <thead class="bg-light">
                        <tr>
                            <th></th>
                            <th class="fw-bold mb-1">Crypto</th>
                            <th class="fw-bold mb-1">Average buying price</th>
                            <th class="fw-bold mb-1">Current price</th>
                            <th class="fw-bold mb-1">Total value</th>
                            <th class="fw-bold mb-1">Total amount</th>
                            <th class="fw-bold mb-1">Profit/Loss</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($cryptoPortfolio as $key => $portfolio)
                            <tr>

                                <td>
                                    <p class="fw-normal mb-1">{{$loop->index + 1}}</p>
                                </td>

                                <td>
                                    <p class="fw-normal mb-1">{{ $portfolio->symbol }}</p>
                                </td>
                                <td>
                                    <p class="fw-normal mb-1">
                                        {{  number_format($portfolio->avg_price, 2) }}{{ $userBankAccount->currency }}
                                    </p>
                                </td>
                                <td>
                                    <p class="fw-normal mb-1">
                                        {{ number_format($cryptoCurrentPrice[$key], 2) }} {{ $userBankAccount->currency }}
                                    </p>
                                </td>
                                <td>
                                    <p class="fw-normal mb-1">
                                        {{ number_format($portfolio->total, 2) }} {{ $userBankAccount->currency }}
                                    </p>
                                </td>
                                <td>
                                    <p class="fw-normal mb-1">{{ number_format($portfolio->amount, 4) }}</p>
                                </td>
                                <td>
                                    @if( number_format(($cryptoCurrentPrice[$key] * $portfolio->amount) -
                                         ($portfolio->avg_price * $portfolio->amount), 2) > 0)
                                        <p class="text-success mb-0">
                                            {{ number_format(($cryptoCurrentPrice[$key] * $portfolio->amount) -
                                             ($portfolio->avg_price * $portfolio->amount), 2) }} {{ $userBankAccount->currency }}</p>
                                    @elseif( number_format(($cryptoCurrentPrice[$key] * $portfolio->amount) -
                                         ($portfolio->avg_price * $portfolio->amount), 2) < 0)
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
