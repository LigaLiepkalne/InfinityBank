<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>InfinityBank</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet"/>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet"/>
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.1.0/mdb.min.css" rel="stylesheet"/>

    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }

        #shape-1,
        #shape-2,
        #shape-3 {
            min-width: 400px;
            height: 400px;
            mix-blend-mode: multiply;
            filter: blur(24px);
        }

        #shape-1 {
            background-color: #c1d7a0;
            left: 20px;
        }

        #shape-2 {
            background-color: #96b6bd;
            right: 20px;
        }

        #shape-3 {
            background-color: #f2f6b3;
            left: 130px;
            top: 50px;
        }

        .scale-up-center {
            animation: scale-up-center 7s cubic-bezier(0.39, 0.575, 0.565, 1) infinite both;
        }

        @keyframes scale-up-center {
            0% {
                transform: translate(0px, 0px) scale(1);
            }
            33% {
                transform: translate(30px, -50px) scale(1.1);
            }
            66% {
                transform: translate(-20px, 20px) scale(0.9);
            }
            100% {
                transform: translate(0px, 0px) scale(1);
            }
        }

        .fade-delay-2000 {
            animation-delay: 2s;
        }

        .fade-delay-4000 {
            animation-delay: 4s;
        }

        #featured-image {
            z-index: 10;
            margin-top: -70px;
        }
    </style>
</head>

<body class="antialiased" style="margin-top: 100px">
<div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-5 sm:pt-300">

    <div class="container my-5">
        <div class="row gx-lg-5 pt-5">
            <div class="col-md-5 mb-9 mb-md-0 d-flex align-items-center">
                <div>
                    <h1 class="display-4 fw-bold lh-1 ls-tight mb-5">
                        InfinityBank <br/>
                        <span class="text-secondary">Unlock the power of infinite banking possibilities</span>
                    </h1>

                    <p class="lead fw-normal text-muted">
                        Take control of your money and make the most of every opportunity.
                        Sign up now to experience the future of financial management
                    </p>

                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}">

                                <button type="button" class="btn btn-dark btn-rounded btn-primary btn-lg">
                                    <b>Go to your profile</b>
                                </button>
                            </a>
                        @else
                            <a href="{{ route('login') }}">
                                <button
                                    type="button"
                                    class="btn btn-dark btn-rounded btn-primary btn-lg">
                                    <b>Login</b>
                                </button>
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}">
                                    <button
                                        type="button"
                                        class="btn btn-dark btn-rounded btn-primary btn-lg">
                                        <b>Open an Account</b>
                                    </button>
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
            <div class="col-md-7 mb-4 mb-md-0 position-relative d-flex align-items-center">

                <img id="featured-image" src="../pngwing.com.png" class="w-100 color-contrast" alt=""/>

                <div id="shape-1" class="rounded-circle position-absolute opacity-70 scale-up-center d-none d-md-block"></div>

                <div id="shape-2" class=" rounded-circle position-absolute opacity-70 scale-up-center fade-delay-2000 d-none d-md-block"></div>

                <div id="shape-3" class="rounded-circle position-absolute opacity-70 scale-up-center fade-delay-4000 d-none d-md-block"></div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
