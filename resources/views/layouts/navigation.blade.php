<style>
    .dropdown-item {
        margin-left: 2.3rem;
    }
    .dropdown-divider {
        margin: 0.5rem 0;
    }

    .dropdown-item:hover {
        background-color: #f5f5f5;
        color: #333;
    }

    .my-class {
        font-size: 18px;
    }

    .settings{
        font-size: 15px;
    }

    .big-text{
        font-size: 40px;
        color: #1a202c;
    }

    nav {
        position: sticky;
        top: 0;
        z-index: 1;
    }

    .line-backgound {
        background: rgb(188,202,207);
        background: -moz-radial-gradient(circle, rgba(188,202,207,1) 7%, rgba(153,183,190,1) 64%, rgba(159,185,185,1) 67%, rgba(206,207,205,1) 100%);
        background: -webkit-radial-gradient(circle, rgba(188,202,207,1) 7%, rgba(153,183,190,1) 64%, rgba(159,185,185,1) 67%, rgba(206,207,205,1) 100%);
        background: radial-gradient(circle, rgba(188,202,207,1) 7%, rgba(153,183,190,1) 64%, rgba(159,185,185,1) 67%, rgba(206,207,205,1) 100%);
        filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#bccacf",endColorstr="#cecfcd",GradientType=1);
    }

</style>

<nav x-data="{ open: false }" class="line-backgound">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center" onclick="location.href='{{ route('dashboard') }}'">
                    <span class="big-text"><b>InfinityBank</b></span>
                        <img id="featured-image" src="../pngwing.com.png" style="width: 40px" alt=""/>
                </div>

                <div x-component>
                    <template>
                        <div class="relative inline-block text-left" x-data="{ open: false }">
                            <div>
                                <slot name="trigger"></slot>
                            </div>

                            <template x-if="open">
                                <div class="absolute right-0 mt-2 w-48 rounded-md shadow-lg">
                                    <slot name="content"></slot>
                                </div>
                            </template>
                        </div>
                    </template>

                    <script>
                        window.livewire.directive('dropdown', {
                            inserted: (el) => {
                                el.addEventListener('mouseenter', () => {
                                    el.setAttribute('x-data', '{ open: true }')
                                })

                                el.addEventListener('mouseleave', () => {
                                    el.setAttribute('x-data', '{ open: false }')
                                })
                            },
                        })
                    </script>
                </div>

                <!-- Navigation Links -->
                <div  class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex
                inline-flex items-center px-1 pt-1 border-indigo-400 text-sm font-semibold leading-5
                text-gray-900 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center text-sm font-semibold text-black-500 hover:text-gray-700
                            hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                <div class="navbar-item my-class">{{ __('Accounts') }}</div>

                                <div class="ml-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <!-- Account -->
                            <x-dropdown-link :href="route('transfer')">
                                {{ __('New Payment') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('transactions.index')">
                                {{ __('Transaction history') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('accounts.create')">
                                {{ __('Open an account') }}
                            </x-dropdown-link>
                        </x-slot>
                    </x-dropdown>
                </div>


                <div  class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex
                inline-flex items-center px-1 pt-1 border-indigo-400 text-sm font-semibold leading-5
                text-gray-900 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center text-sm font-bold text-black-500 hover:text-gray-700
                            hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                <div class="navbar-item my-class"> {{ __('Crypto Investments') }}</div>

                                <div class="ml-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <!-- Crypto Investments -->
                            <x-dropdown-link :href="route('crypto.index')">
                                {{ __('Trade') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('crypto-transactions.index')">
                                {{ __('Transaction history') }}
                            </x-dropdown-link>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                            <div class="settings font-semibold">Welcome, {{ Auth::user()->name }} {{ Auth::user()->surname }}!</div>

                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">

                        <x-dropdown-link data-toggle="modal" data-target="#codeModal">
                            {{ __('Code Card') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
