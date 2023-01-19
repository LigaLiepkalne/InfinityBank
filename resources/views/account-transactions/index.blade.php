
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

    <!-- Font Awesome -->

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

        form{
            margin: 0 auto;
            width: 50%;
            padding-bottom: 20px;
            padding-top: 10px;
        }

    </style>

    <x-app-layout>

        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet"/>
        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet"/>
        <!-- MDB -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.1.0/mdb.min.css" rel="stylesheet"/>

        <x-slot name="header">

            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Transaction history
            </h2>

            <form method="GET" action="{{ route('transactions.index') }}">
                <!-- Select account-->
                <div class="form-group">
                    <x-label for="account">Account</x-label>
                    <select style="color: #2563eb; display: inline-block; margin-left:25px; margin-right: 10px;"
                            name="account" id="account"
                            class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-5/6" required autofocus>
                        <option selected>Select your account number</option>
                        @foreach ($userBankAccounts as $index => $account)
                            <option value="{{ $account->number }}">{{ $account->number }}</option>
                        @endforeach
                    </select>
                </div>
                <!-- Date inputs-->
                <div class="form-group">
                    <x-label for="start-date">Start Date</x-label>
                    <x-input type="date" name="start-date" id="start-date" class="form-control"/>
                </div>
                <div class="form-group">
                    <x-label for="end-date">End Date</x-label>
                    <x-input type="date" name="end-date" id="end-date" class="form-control"/>
                </div>

                <h6 class="font-semibold text-xl text-gray-800 leading-tight">Search by</h6>

                <div class="form-group">
                    <x-label for="sender">Sender</x-label>
                    <x-input type="text" name="sender"  class="form-control"/>
                </div>

                <div class="form-group">
                    <x-label for="recipient">Recipient</x-label>
                    <x-input type="text" name="recipient"  class="form-control"/>
                </div>

                <button type="submit" class="btn btn-primary">Filter</button>
            </form>

        </x-slot>

        <div class="table-info bg-white max-w-8xl">
            <h5 class="font-semibold"> </h5>
            <h5 class="font-semibold"> </h5>
            <h5 class="font-semibold"></h5>
        </div>



        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">


                        <div class="table-wrapper-scroll-y my-custom-scrollbar">
                            <table class="table align-middle mb-0 bg-white table-hover">
                                <thead class="bg-light">
                                <tr>
                                    <th></th>
                                    <th>Date</th>
                                    <th>Paid to/Received from</th>
                                    <th>Details</th>
                                    <th>Amount</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($transactions as $transaction)
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
                                                <p class="text-danger mb-0">{{ $transaction->sent_amount }} {{ $transaction->received_currency }}</p>
                                            </td>
                                        @else
                                            <td>
                                                <p class="fw-normal mb-1">{{ $transaction->sender_name }} {{ $transaction->sender_surname }}</p>
                                                <p class="text-muted mb-0">{{ $transaction->sender_account}}</p>
                                            </td>
                                            <td>
                                                <p class="fw-normal mb-1">{{ $transaction->details }}</p>
                                                <p class="text-muted mb-0">{{ abs($transaction->sent_amount) }}, {{ $transaction->received_currency }}</p>
                                                <p class="text-muted mb-0">EXCHANGE RATE:{{ $transaction->conversion_rate }}</p>
                                            </td>
                                            <td>
                                                <p class="text-success mb-0">+{{ $transaction->received_amount }} {{ $transaction->sent_currency }} </p>
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
