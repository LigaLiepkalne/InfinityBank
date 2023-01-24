<style>
    .crypto-inline {
        display: flex;
        align-items: center;
    }

    .crypto-name {
        margin-left: 10px;
    }

    .grayed-out {
        color: gray;
    }

    .highlights {
        width: 100%;
        flex-wrap: wrap;
        display: grid;
        grid-template-columns: repeat(2, 1fr);
    }

    .form {
        padding-inline-start: 20px;
        padding-inline-end: 20px;
    }
</style>

<script>
    $(document).ready(function () {
        $("#formId").change(function () {
            this.form.submit();
        });
    });
</script>

@include('userSettings.code-card')
<x-app-layout>
    <x-slot name="header">
            <form method="GET" action="/trade/search">
                <h6 class="text-sm text-gray-400">Cryptocurrency prices sourced from CoinMarketCap</h6>
                <div class="form-inline">
                    <h1 class="font-semibold text-xl">Cryptocurrency Prices by Market Cap</h1>
                    <div class="form">
                        <input type="search" name="query"
                               class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300
                               focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-5/6"
                               placeholder="Search crypto..."/>
                    </div>
            </form>
            <form method="GET" action="" id="formId" style="display: flex; align-items: center; margin-top: 15px">
                <select id="formId" name="currency" style="min-width: 100px;" required
                        class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300
                        focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-5/6"
                        name="currency">
                    @foreach($currencies as $currency)
                        <option value="{{ $currency }}" {{ $currency === 'EUR' ? 'selected' : '' }}>{{ $currency }}</option>
                    @endforeach
                </select>
                <button type="submit" style="margin-left: 5px; margin-top:5px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor"
                         class="bi bi-arrow-right-square" viewBox="0 0 16 16" color="#cddade">
                        <path fill-rule="evenodd"
                              d="M15 2a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2zM0 2a2 2
                               0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2zm4.5 5.5a.5.5 0 0 0 0
                               1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708
                               .708L10.293 7.5H4.5z"
                        />
                    </svg>
                </button>
            </form>
            </div>
    </x-slot>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-9">
            <div class="highlights">
                <div class="py-6" style="margin-right: 10px">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h4 class="mb-3">Top 3 by market cap</h4>
                            <table class="table table-hover text-nowrap">
                                <thead>
                                <tr>
                                    <th class="fw-bold mb-1">#</th>
                                    <th class="fw-bold mb-1">Name</th>
                                    <th class="fw-bold mb-1">Price</th>
                                    <th class="fw-bold mb-1">Price change 24h</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($descendingCryptoTop as $index => $crypto)
                                    <tr>
                                        <th scope="row">{{ $index+1 }}</th>
                                        <td class="crypto-inline"><a
                                                href="/trade/search?query={{ $crypto->getSymbol() }}">
                                                <img src="{{ $crypto->getLogoURL() }}" alt="crypto-logo" width="20"
                                                     height="20"></a>
                                            <span class="crypto-name">{{ $crypto->getName() }} <span class="grayed-out">{{ $crypto->getSymbol() }}</span></span>
                                        </td>
                                        <td>
                                            {{ $crypto->getCurrency() }} {{ number_format($crypto->getPrice(), 2) }}
                                        </td>
                                        @if($crypto->getPercentChange24h() >= 0)
                                            <td class="text-success">
                                                <i class="fas fa-caret-up me-1"></i>{{ number_format($crypto->getPercentChange24h(), 2) }}%
                                            </td>
                                        @else
                                            <td class="text-danger">
                                                <i class="fas fa-caret-down me-1"></i> {{ number_format($crypto->getPercentChange24h(), 2) }}%
                                            </td>
                                        @endif
                                        @endforeach
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="parent-element py-6">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h4 class="mb-3">Top 3 Lowest by Market cap</h4>
                            <table class="table table-hover text-nowrap">
                                <thead>
                                <tr>
                                    <th class="fw-bold mb-1">#</th>
                                    <th class="fw-bold mb-1">Name</th>
                                    <th class="fw-bold mb-1">Price</th>
                                    <th class="fw-bold mb-1">Price change 24h</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($ascendingCryptoTop as $index => $crypto)
                                    <tr>
                                        <th scope="row">{{ $index+1 }}</th>
                                        <td class="crypto-inline">
                                            <a href="/trade/search?query={{ $crypto->getSymbol() }}">
                                            <img src="{{ $crypto->getLogoURL() }}" alt="crypto-logo" width="20" height="20">
                                            </a>
                                            <span class="crypto-name">{{ $crypto->getName() }}
                                                <span class="grayed-out">{{ $crypto->getSymbol() }}</span>
                                            </span>
                                        </td>
                                        <td>
                                            {{ $crypto->getCurrency() }} {{ number_format($crypto->getPrice(), 2) }}
                                        </td>
                                        @if($crypto->getPercentChange24h() >= 0)
                                            <td class="text-success">
                                                <i class="fas fa-caret-up me-1"></i> {{ number_format($crypto->getPercentChange24h(), 2) }} %
                                            </td>
                                        @else
                                            <td class="text-danger">
                                                <i class="fas fa-caret-down me-1"></i> {{ number_format($crypto->getPercentChange24h(), 2) }} %
                                            </td>
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
                            <th class="fw-bold mb-1">#</th>
                            <th class="fw-bold mb-1">Name</th>
                            <th class="fw-bold mb-1">Price</th>
                            <th class="fw-bold mb-1">1h %</th>
                            <th class="fw-bold mb-1">24h %</th>
                            <th class="fw-bold mb-1">7d %</th>
                            <th class="fw-bold mb-1">Market cap</th>
                            <th class="fw-bold mb-1">Volume (24h)</th>
                            <th class="fw-bold mb-1"></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($cryptoCurrencies as $index => $crypto)
                            <tr>
                                <th scope="row">{{ $index+1 }}</th>
                                <td class="crypto-inline"><a href="/trade/search?query={{ $crypto->getSymbol() }}">
                                        <img src="{{ $crypto->getLogoURL() }}" alt="crypto-logo" width="35" height="35"></a>
                                    <span class="crypto-name">
                                        {{ $crypto->getName() }} <span class="grayed-out">{{ $crypto->getSymbol() }}</span>
                                    </span>
                                </td>
                                <td> {{ $crypto->getCurrency() }} {{ number_format($crypto->getPrice(), 2) }}</td>
                                @if($crypto->getPercentChange1h() >= 0)
                                    <td class="text-success">
                                        <i class="fas fa-caret-up me-1"></i> {{ number_format($crypto->getPercentChange1h(), 2) }} %
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
                                <td>{{ $crypto->getCurrency() }} {{ number_format($crypto->getMarketCap(), 3) }}</td>
                                <td>{{ $crypto->getCurrency() }} {{ number_format($crypto->getvolume24h(), 3) }}</td>
                                <td>
                                    <a href="/trade/search?query={{ $crypto->getSymbol() }}">
                                        <x-button class="ml-4" style="background-color: #bccacf; border-radius: 30px">
                                            <b>{{ __('Trade') }}</b>
                                        </x-button>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
</x-app-layout>
