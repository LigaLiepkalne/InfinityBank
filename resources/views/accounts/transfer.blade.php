<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

@include('userSettings.code-card')

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            New Payment
        </h2>
    </x-slot>

    <style>
        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 20px;
            margin-bottom: auto;

        }

        label {
            margin: 17px;
        }

        button {
            display: block;
            margin: 0 auto;
        }

        input {
            width: 340px;
        }



        h3 {
            font-weight: bold;
            color:rgb(55 65 81);
            text-decoration: underline;
        }

        p span {
            font-weight: bold;
            color: rgb(55 65 81)
        }

    </style>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            // hide password and code fields by default
            $('#password').hide();
            $('#code').hide();

            // hide labels for password and code fields by default
            $('label[for="password"]').hide();
            $('label[for="code"]').hide();


            //redirect back to /dashboard if user clicks on cancel button
            $('#cancel-button').click(function() {
                if ($('#cancel-button').text() === 'Cancel') {
                    window.location.href = '/dashboard';
                }
            });


            // check if all fields are filled
            $('#recipient, #amount, #to_account, #from_account, #details').change(function() {
                if ($('#recipient').val() && $('#amount').val() && $('#to_account').val() && $('#from_account').val() && $('#details').val()) {
                    $('#proceed-button').prop('disabled', false);
                } else {
                    $('#proceed-button').prop('disabled', true);
                }
            });

            $('#proceed-button').click(function() {
                // show password and code fields
                $('#password').show();
                $('#code').show();
                $('label[for="password"]').show();
                $('label[for="code"]').show();
                $('#summary-container').show();

                // hide other fields
                $('#recipient').hide();
                $('#amount').hide();
                $('#to_account').hide();
                $('#from_account').hide();
                $('#balance').hide();
                $('#to_currency').hide();
                //$('#currency').hide();
                $('#details').hide();

                // toggle visibility of their labels
                $('label[for="recipient"]').hide();
                $('label[for="amount"]').hide();
                $('label[for="to_account"]').hide();
                $('label[for="from_account"]').hide();
                $('label[for="details"]').hide();

                // store the user input values in variables
                const recipient = $('#recipient').val();
                const amount = $('#amount').val();
                const toAccount = $('#to_account').val();
              //  const currency = $('#currency').val();
                const details = $('#details').val();
                const fromAccount = $('#from_account').val();

                // retrieve the currency of the from account
               // const fromAccountCurrency = $('#from_account').find(':selected').data('currency');
                // retrieve the currency of the to account
              //  const toAccountCurrency = $('#to_currency').text();

                // update the text of the corresponding span elements in the summary
                $('span[name="recipient"]').text(recipient);
                $('span[name="to_account"]').text(toAccount);
                $('span[name="amount"]').text(amount);
               // $('span[name="currency"]').text(currency);
                $('span[name="details"]').text(details);
                $('span[name="from_account"]').text(fromAccount);

                // get the selected option element
                //const selectedOption = $('#currency').find(':selected');
                // get the exchange rate from the data attribute
                //const exchangeRate = selectedOption.data('rate').toFixed(2);
                // update the exchange rate
                //$('#exchange-rate').text(exchangeRate);
                // calculate the amount in the currency of the to account
               // const convertedAmount = (amount * exchangeRate).toFixed(2);
               // $('span[name="converted-amount"]').text(convertedAmount);

                $('span[name="currency1"]').text(toAccountCurrency + ' (exchange rate: ' + exchangeRate + ' ' + fromAccountCurrency + ' - ' + toAccountCurrency + ')');

                // change button text to "Transfer"
                $(this).text('Confirm Payment');

                //change Canbel button text to "Back" and display currently hidden fields and hide password and code fields and do not direct to /dashboard
                $('#cancel-button').text('Back').click(function() {
                    $('#recipient').show();
                    $('#amount').show();
                    $('#to_account').show();
                    $('#from_account').show();
                    $('#balance').show();
                    $('#to_currency').show();
                    //$('#currency').show();
                    $('#details').show();

                    $('label[for="recipient"]').show();
                    $('label[for="amount"]').show();
                    $('label[for="to_account"]').show();
                    $('label[for="from_account"]').show();
                    $('label[for="details"]').show();

                    $('#password').hide();
                    $('#code').hide();
                    $('label[for="password"]').hide();
                    $('label[for="code"]').hide();
                    $('#summary-container').hide();

                    //disable redirection for Cancel button
                    $(this).text('Cancel');

                    $('#proceed-button').text('Proceed');

                });

            });
        });

    </script>

    <script>
        $(document).ready(function() {
            $('#from_account').change(function() {
                const balance = $(this).find(':selected').data('balance');
                const currency = $(this).find(':selected').data('currency');
                $('#balance').text('Available: ' + balance + ' ' + currency);
            });
        });
        </script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('to_account').addEventListener('change', function() {
                // Send an AJAX request to the server to retrieve the currency
                fetch('/api/to_currency?account=' + this.value)
                    .then(response => response.json())
                    .then(data => {
                        // Update the form with the returned currency
                        document.getElementById('to_currency').innerHTML = data.currency;
                    });
            });
        });
        </script>
<style>

    .label-text {
        font-family: sans-serif;
        color: #333;
        font-size: 14px;
    }
    </style>

    @if (session('success'))
        <div class="mx-auto text-center font-medium text-green-600" style="margin-top: 5px">
            {{ session('success') }}
        </div>
    @endif

    <form style="margin-top: 10px" method="POST" action={{ route('transfer') }}>
        <x-transfer-errors :errors="$errors" />
        <br>

        @csrf

        <!-- input Beneficiary-->
        <div style="display: flex; flex-direction: column;">
            <div style="display: flex; flex-direction: row; align-items: center;">
                <x-label for="recipient" style="margin-right: 10px;">
                    Beneficiary<span style="color: red;">*</span>
                </x-label>
                <x-input id="recipient" class="block mt-1 w-5/6" style="margin-left:63px;" type="text" name="recipient" :value="old('recipient')" required autofocus />
            </div>

            <!-- input Beneficiary's account-->
            <div style="display: flex; flex-direction: row; align-items: center;">
                <x-label for="to_account" class="w-1/6" style="margin-right: 10px;">
                    Beneficiary's account<span style="color: red;">*</span>
                </x-label>
                <x-input id="to_account" class="block mt-1 w-5/6" style="margin-left:1px; margin-right:8px;" type="text" name="to_account" required autofocus />
                <span id="to_currency" class="w-1/6 block font-medium text-sm text-gray-700"></span>
            </div>

            <!-- Select FROM account-->
            <div style="display: flex; flex-direction: row; align-items: center;">
                <x-label for="from_account" class="w-1/6" style="margin-right: 10px;">
                    Pay from account<span style="color: red;">*</span>
                </x-label>

                <select style="color: #2563eb; display: inline-block; margin-left:25px; margin-right: 10px;" name="from_account" id="from_account" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-5/6" required autofocus>
                    @foreach ($userBankAccounts as $index => $account)
                        @if ($index === 0)
                            <option value="{{ $account->number }}" data-balance="{{ $account->balance }}" data-currency="{{ $account->currency }}" selected>
                                {{ $account->number }} {{ $account->user->name }} {{ $account->user->surname }}
                            </option>
                        @else
                            <option value="{{ $account->number }}" data-balance="{{ $account->balance }}" data-currency="{{ $account->currency }}">
                                {{ $account->number }} {{ $account->user->name }} {{ $account->user->surname }}
                            </option>
                        @endif
                    @endforeach
                </select>
                <x-label id="balance" style="display: inline-block; margin-left: unset;" class="w-1/6 block font-medium text-sm text-gray-700">Available: {{ $userBankAccounts[0]->balance }} {{ $userBankAccounts[0]->currency }}</x-label>
            </div>

            <!-- input AMOUNT-->
            <div style="display: flex; flex-direction: row; align-items: center; width: 300px;">
                <x-label for="amount" class="w-1/6" style="margin-right: 10px;">
                    Amount<span style="color: red;">*</span>
                </x-label>
                <x-input id="amount" class="block mt-1 w-5/6" style="margin-left:82px; margin-right:5px;" type="text" name="amount" required autofocus />

                <!-- Select currency-->

            </div>

            <!-- make input for Details-->
            <div style="display: flex; flex-direction: row; align-items: center;">
                <x-label for="details" class="w-1/6" style="margin-right: 10px;">
                    Details<span style="color: red;">*</span>
                </x-label>
                <x-input id="details" class="block mt-1 w-5/6" style="margin-left:88px;" type="text" name="details" autofocus />
            </div>

            <!-- Payment summary-->
            <div id="summary-container" style="display: none;">
                <div style="border: 1px solid #b7b7b7; padding: 10px; border-radius: 10px">
                    <h3>Payment summary</h3>
                    <p>Beneficiary: <span name="recipient"></span></p>
                    <p>Beneficiary's account: <span name="to_account"></span></p>

                    <p>Payment amount: <span name="converted-amount"></span> <span name="currency1"></span></p>
                    <p>Details: <span name="details"></span></p>


                </div>
            </div>

            <!-- Security code-->
            <div style="display: flex; flex-direction: row; align-items: center; margin-top: 15px">
                <x-label for="code" class="w-1/6" style="margin-right: 25px;" autocomplete="off">
                    Security code No. {{ $codeIndex }}<span style="color: red;">*</span>
                </x-label>
                <x-input type="text" id="code" class="block mt-1 w-5/6" name="code" required autofocus />
            </div>
            <input type="hidden" name="code_index" value="{{ $codeIndex }}">

            <!-- input PASSWORD-->
            <div style="display: flex; flex-direction: row; align-items: center;">
                <x-label for="password" class="w-1/6" style="margin-right: 10px;" autocomplete="off">
                    Password<span style="color: red;">*</span>
                </x-label>
                <x-input id="password" class="block mt-1 w-5/6" style="margin-left:75px;" type="password" name="password" required autofocus />
            </div>



            <div style="display: inline-flex; justify-content: center; align-items: center">

                <!-- Cancel button with href /dashboard-->

                <div class="flex items-center justify-right mt-4">
                    <x-button id="cancel-button" style="background-color: #b882b9; color: white; margin-right: 10px;">
                        {{ __('Cancel') }}
                    </x-button>
                </div>

                <div class="flex items-center justify-right mt-4">
                    <x-button id="proceed-button" disabled style="margin-right: 10px;">
                        {{ __('Continue') }}
                    </x-button>
                </div>

            </div>

        </div>
    </form>



</x-app-layout>
