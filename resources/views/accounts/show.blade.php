<x-app-layout>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
            crossorigin="anonymous"></script>

    <!-- Close account form-->
    <style>
        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 20px;
            margin-bottom: auto;

        }

        .form-group {
            display: flex;
            align-items: center;
        }

        .form-group label {
            width: 100px;

        }

        .form-group input,
        .form-group select {
            flex: 1;
        }
    </style>

    <x-slot name="header">

        <ul class="nav nav-tabs justify-content-end" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button
                    class="nav-link"
                    id="label-tab"
                    data-bs-toggle="tab"
                    data-bs-target="#label"
                    type="button"
                    role="tab"
                    aria-controls="label"
                    aria-selected="false"
                >Update Label
                </button
                >
            </li>
            <li class="nav-item" role="presentation">
                <button
                    class="nav-link"
                    id="profile-tab"
                    data-bs-toggle="tab"
                    data-bs-target="#profile"
                    type="button"
                    role="tab"
                    aria-controls="profile"
                    aria-selected="false"
                >Close Account
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button
                    class="nav-link active"
                    id="transactions-tab"
                    data-bs-toggle="tab"
                    data-bs-target="#transactions"
                    type="button"
                    role="tab"
                    aria-controls="transactions"
                    aria-selected="true"
                >Current month transactions
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button
                    class="nav-link"
                    id="crypto-portfolio-tab"
                    data-bs-toggle="tab"
                    data-bs-target="#crypto-portfolio"
                    type="button"
                    role="tab"
                    aria-controls="crypto-portfolio"
                    aria-selected="false"
                >Crypto Portfolio
                </button>
            </li>
        </ul>

    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade" id="label" role="tabpanel" aria-labelledby="label-tab">

                            <!-- Label Edit form-->
                            <form method="POST" action="/accounts/{{ $userBankAccount->id }}/edit">
                                @csrf
                                @method('PUT')

                                <div class="form-group">
                                    <!-- Type -->
                                    <x-label for="label">New Label <span style="color: red;">*</span></x-label>
                                    <x-input id="label" class="block mt-1 w-5/6" type="text" name="label"
                                             :value="$userBankAccount->label" required autofocus/>
                                </div>

                                <div class="flex items-center justify-left">
                                    <x-button class="ml-4">
                                        {{ __('Update') }}
                                    </x-button>
                                </div>
                            </form>
                        </div>

                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">

                            <!-- Display errors -->
                            @if (session('success'))
                                <div class="mx-auto text-center font-medium text-green-600" style="margin-top: 5px">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if (session('error'))
                                <div class="mx-auto text-center font-medium text-red-600" style="margin-top: 5px">
                                    {{ session('error') }}
                                </div>
                            @endif


                            <form method="POST" action="/accounts/{{ $userBankAccount->id }}/delete">
                                @csrf
                                @method('DELETE')

                                <div class="form-group">
                                    <!-- Label -->
                                    <x-label for="password">
                                        Password <span style="color: red;">*</span>
                                    </x-label>
                                    <x-input id="password" class="block mt-1 w-full" type="text" name="password" required
                                             autofocus/>
                                </div>


                                <div class="form-group">
                                    <!-- Type -->
                                    <x-label for="code">
                                        Security code No. {{ $codeIndex }}<span style="color: red;">*</span>
                                    </x-label>
                                    <x-input type="text" id="code" class="block mt-1 w-5/6" name="code" required autofocus/>
                                    <input type="hidden" name="code_index" value="{{ $codeIndex }}">
                                </div>

                                <div class="flex items-center justify-end ">
                                    <x-button class="ml-4">
                                        {{ __('Close') }}
                                    </x-button>
                                </div>
                            </form>
                        </div>

                        <div class="tab-pane fade show active" id="transactions" role="tabpanel" aria-labelledby="transactions-tab">
                            @include('account-transactions.current-month-transactions')
                        </div>

                        <div class="tab-pane fade show" id="crypto-portfolio" role="tabpanel" aria-labelledby="crypto-portfolio-tab">
                            @include('crypto.show-portfolio')
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>


    <!-- Include code-card.blade.php-->
    @include('userSettings.code-card')

</x-app-layout>
