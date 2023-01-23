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

@include('userSettings.code-card')

<style>
    .crypto-inline{
        display: flex;
        align-items: center;
    }

    .crypto-name{
        margin-left: 10px;
    }

    .grayed-out {
        color: gray;
    }

    .highlights {
        width: 100%; /* make the parent element 80% of the width of its parent */
        flex-wrap: wrap; /* make the two divs take up the full width of their parent element and wrap if the content inside is too wide. */
        display: grid;
        grid-template-columns: repeat(2, 1fr);
    }

    th, td, tr {
        text-align: center;
        border-color: transparent;
        border-width: 0;
    }
</style>

<script>
    $(document).ready(function() {
        $("#formId").change(function() {
            this.form.submit();
        });
    });
</script>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <form method="GET" action="/trade/search">
                <div><h6 class="text-xs text-gray-400">Cryptocurrency prices sourced from CoinMarketCap</h6></div>

                <div class="form-inline">
            Cryptocurrency Prices by Market Cap

                <div class="form" style="padding-inline-start:20px; padding-inline-end:20px;">
                    <input type="search" name="query" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-5/6" placeholder="Search crypto..." aria-label="Search"/>
                </div>

            </form>

            <form method="GET" action="" id="formId" style="display: flex; align-items: center; margin-top: 20px">
                <select id="formId" name="currency" style="min-width: 100px; " required class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-5/6" name="currency" >
                    @foreach($currencies as $currency)
                        <option value="{{ $currency }}" {{ $currency === 'EUR' ? 'selected' : '' }}>{{ $currency }}</option>
                    @endforeach
                </select>
                <button type="submit" style="margin-left: 5px; margin-top:5px;"><svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-arrow-right-square" viewBox="0 0 16 16" color="#cddade">
                        <path fill-rule="evenodd" d="M15 2a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2zM0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2zm4.5 5.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z"/>
                    </svg></button>

            </form>
            </div>

        </h2>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-9 ">

            <div class="highlights bg-transparent">

                <div class="parent-element py-6" style="display: inline-block; margin-right: 10px">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h4>Top 3 by market cap</h4>
                            <table class="table table-hover text-nowrap">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Price change 24h</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($descendingCryptoTop as $index => $crypto)
                                    <tr>
                                        <th scope="row">{{ $index+1 }}</th>

                                        <td class="crypto-inline"> <a href="/trade/search?query={{ $crypto->getSymbol() }}">
                                                <img src="{{ $crypto->getLogoURL() }}" alt="crypto-logo" width="20" height="20"></a>
                                            <span class="crypto-name">{{ $crypto->getName() }} <span class="grayed-out">{{ $crypto->getSymbol() }}</span></span>
                                        </td>

                                        <td>
                                            {{ $crypto->getCurrency() }} {{ number_format($crypto->getPrice(), 2) }}
                                        </td>

                                        @if($crypto->getPercentChange24h() >= 0)
                                            <td class="text-success"><i class="fas fa-caret-up me-1"></i> {{ number_format($crypto->getPercentChange24h(), 2) }} %</td>
                                        @else
                                            <td class="text-danger"><i class="fas fa-caret-down me-1"></i> {{ number_format($crypto->getPercentChange24h(), 2) }} %</td>
                                        @endif
                                        @endforeach
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>





                <div class="parent-element py-6" style="display: inline-block;">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h4>Top 3 Lowest by Market cap</h4>
                            <table class="table table-hover text-nowrap">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Price change 24h</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($ascendingCryptoTop as $index => $crypto)
                                    <tr>
                                    <th scope="row">{{ $index+1 }}</th>

                                    <td class="crypto-inline"> <a href="/trade/search?query={{ $crypto->getSymbol() }}">
                                            <img src="{{ $crypto->getLogoURL() }}" alt="crypto-logo" width="20" height="20"></a>
                                        <span class="crypto-name">{{ $crypto->getName() }} <span class="grayed-out">{{ $crypto->getSymbol() }}</span></span>
                                    </td>

                                    <td>
                                        {{ $crypto->getCurrency() }} {{ number_format($crypto->getPrice(), 2) }}
                                    </td>

                                        @if($crypto->getPercentChange24h() >= 0)
                                            <td class="text-success"><i class="fas fa-caret-up me-1"></i> {{ number_format($crypto->getPercentChange24h(), 2) }} %</td>
                                        @else
                                            <td class="text-danger"><i class="fas fa-caret-down me-1"></i> {{ number_format($crypto->getPercentChange24h(), 2) }} %</td>
                                        @endif
                                @endforeach
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

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
                        @foreach ($cryptoCurrencies as $index => $crypto)
                            <tr>
                                <th scope="row">{{ $index+1 }}</th>
                                <td class="crypto-inline"> <a href="/trade/search?query={{ $crypto->getSymbol() }}">
                                    <img src="{{ $crypto->getLogoURL() }}" alt="crypto-logo" width="35" height="35"></a>
                                    <span class="crypto-name">{{ $crypto->getName() }} <span class="grayed-out">{{ $crypto->getSymbol() }}</span></span>
                                </td>
                                <td> {{ $crypto->getCurrency() }} {{ number_format($crypto->getPrice(), 2) }}</td>
                                @if($crypto->getPercentChange1h() >= 0)
                                    <td class="text-success"><i class="fas fa-caret-up me-1"></i> {{ number_format($crypto->getPercentChange1h(), 2) }} %</td>
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
                                    <a href="/trade/search?query={{ $crypto->getSymbol() }}">
                                        <x-button class="ml-4 text-black" style="background-color: #30464a;">
                                            {{ __('Trade') }}
                                        </x-button></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

    </x-app-layout>
