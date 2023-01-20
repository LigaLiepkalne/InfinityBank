
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

<x-app-layout>
    @include('userSettings.code-card')

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
        <!-- Include code-card.blade.php-->

    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    @if (session('success'))
                        <div class="mx-auto text-center font-medium text-green-600" style="margin-top: 5px">
                            {{ session('success') }}
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>

    <div class="container my-3">
        <!--Section: Content-->
        <section class="dark-grey-text">
            <!-- Section heading -->
            @foreach ($userBankAccounts as $account)
            <!-- Grid row -->
            <div class="row">
                <div class="col-12 mb-4">
                    <div class="card z-depth-0 bordered border-light">
                        <div class="card-body p-0">
                            <div class="row mx-0">
                                <div class="col-md-8 grey lighten-4 rounded-left pt-4">
                                    <h5 class="font-weight-bold"><a href="accounts/{{ $account->id }}">{{ $account->number }}</a></h5>
                                    <p class="font-weight-light text-muted mb-4">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quibusdam vitae, fuga similique quos aperiam tenetur quo ut rerum debitis.</p>
                                </div>
                                <div class="col-md-4 text-center pt-4">
                                    <p class="h2 font-weight-normal">{{ $account->balance }}, {{ $account->currency }}</p>
                                    <p class="h5 font-weight-light text-muted mb-4">details</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Grid row -->
        </section>
        <!--Section: Content-->
        @endforeach
    </div>


    <h1>Show totol value across all accounts</h1>
    <h1>Show recent transaction</h1>
    <h1>the number of transactions in the past month</h1>
    <h1>Crypto Portfolios for acc in sigle veiw add also crypto trans? or in overveiw add existing crypto portfolios</h1>

    <ul>
        @foreach ($userBankAccounts as $account)
            <li><a href="accounts/{{ $account->id }}">{{ $account->number }}</a>: {{ $account->balance }}, {{ $account->currency }}</li>
        @endforeach
    </ul>

</x-app-layout>

<div class="container vh-100">
    <div class="row gx-lg-5 h-100 d-flex align-content-center text-white">
        <div class="col-md-6 mb-4 mb-md-0 d-flex align-items-center">
            <div class="animation-delay fade">
                <h1 class="mb-4 opacity-90" style="color: hsl(218, 81%, 95%)">
                    Exlusive offer
                </h1>

                <h5 class="mb-4 opacity-80" style="color: hsl(218, 81%, 90%)">
                    Lorem ipsum dolor sit amet consectetur.
                </h5>

                <p class="mb-4 opacity-70" style="color: hsl(218, 81%, 85%)">
                    Lorem ipsum dolor, sit amet consectetur adipisicing elit.
                    Temporibus, expedita iusto veniam atque, magni tempora mollitia
                    dolorum consequatur nulla, neque debitis eos reprehenderit quasi
                    ab ipsum nisi dolorem modi. Quos?
                </p>

                <a
                    class="btn btn-white btn-rounded btn-lg me-3 opacity-80"
                    href="#"
                    role="button"
                    data-ripple-color="hsl(218, 41%, 45%)"
                >Buy now</a
                >
                <a
                    class="btn btn-outline-white btn-rounded btn-lg opacity-80"
                    href="#"
                    role="button"
                >Learn more</a
                >
            </div>
        </div>

        <div class="col-md-5 offset-md-1 mb-4 mb-md-0 position-relative">
            <div
                id="shape-1"
                class="
                  position-absolute
                  rounded-circle
                  shadow-5-strong
                  fade fade-delay-small
                  "
            ></div>
            <div
                id="shape-2"
                class="position-absolute shadow-5-strong fade fade-delay-medium"
            ></div>
            <div
                id="card-custom"
                class="card shadow-6 rounded-6 fade fade-delay-big"
            >
                <div class="card-body p-5 opacity-90 ls-widest">
                    <h2>
                        <strong>Platinium</strong> <span class="fw-light">card</span>
                    </h2>
                </div>
                <div
                    class="card-footer px-5 border-0 opacity-90 ls-widest fw-light"
                >
                    <img
                        id="chip"
                        class="mb-5"
                        src="https://ascensus-youtube-projects.mdbgo.io/img/chip.png"
                        alt="chip"
                    />
                    <h5 class="mb-5">1234 5678 9012 3456</h5>
                    <p class="mb-2">John Doe</p>
                    <p class="mb-5">12/25</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    body {
        background-color: hsl(218, 41%, 15%);
        background-image: radial-gradient(
            650px circle at 0% 0%,
            hsl(218, 41%, 35%) 15%,
            hsl(218, 41%, 30%) 35%,
            hsl(218, 41%, 20%) 75%,
            hsl(218, 41%, 19%) 80%,
            transparent 100%
        ),
        radial-gradient(
            1250px circle at 100% 100%,
            hsl(218, 41%, 45%) 15%,
            hsl(218, 41%, 30%) 35%,
            hsl(218, 41%, 20%) 75%,
            hsl(218, 41%, 19%) 80%,
            transparent 100%
        );
    }
    #card-custom {
        width: 350px;
        height: 500px;
        background: hsla(0, 0%, 100%, 0.15);
        backdrop-filter: blur(30px);
    }

    #shape-1 {
        height: 220px;
        width: 220px;
        bottom: -100px;
        left: -90px;
        background: radial-gradient(#44006b, #ad1fff);
        z-index: -10;
    }
    #shape-2 {
        border-radius: 38% 62% 63% 37% / 70% 33% 67% 30%;
        top: -100px;
        right: 10px;
        width: 300px;
        height: 300px;
        background: radial-gradient(#44006b, #ad1fff);
        z-index: -10;
    }
    #chip {
        width: 50px;
    }

    .fade {
        animation-duration: 1s;
        animation-fill-mode: both;
        padding: auto;
        animation-name: fade-in;
    }

    .fade-delay-small {
        animation-delay: 0.15s;
    }

    .fade-delay-medium {
        animation-delay: 0.3s;
    }
    .fade-delay-big {
        animation-delay: 0.4s;
    }
    @keyframes slidein {
        0% {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }
</style>

<script>
    VanillaTilt.init(document.querySelector("#card-custom"), {
        startX: 45,
        startY: 45,
        reset: false,
    });

    //It also supports NodeList
    VanillaTilt.init(document.querySelectorAll("#card-custom"));
</script>





