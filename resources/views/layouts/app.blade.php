<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="https://cdn-icons-png.flaticon.com/512/5100/5100994.png" type="image/x-icon">

    <title>{{ config('app.name', 'Jcrify') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
    {{-- <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css"  rel="stylesheet" /> --}}
    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/2.1.7/css/dataTables.dataTables.css"> --}}
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
    @charset "utf-8";
    /* CSS Document */

    /******* Common Element CSS Start ******/
    * {
        margin: 0px;
        padding: 0px;
        outline: none;
    }

    body {
        background-color: #3f5de1;
    }

    .main-container {
        min-height: 100vh;
        display: flex;
        display: -webkit-flex;
        align-items: center;
        -webkit-align-items: center;
        height: 560px;
        overflow: hidden;
    }

    .main {
        margin: 0px auto;
        width: 480px;
        height: 480px;
        position: relative;
    }

    .big-circle {
        height: 100%;
        width: 100%;
        position: relative;
        border: 3px solid #6495f2;
        border-radius: 50%;
        display: flex;
        display: -webkit-flex;
        align-items: center;
        -webkit-align-items: center;
        justify-content: center;
        -webkit-justify-content: center;
        animation: Rotate 20s linear infinite;
        -webkit-animation: Rotate 20s linear infinite;
    }

    .icon-block {
        width: 64px;
        height: 64px;
        position: absolute;
        border-radius: 50%;
        display: flex;
        display: -webkit-flex;
        align-items: center;
        -webkit-align-items: center;
        justify-content: center;
        -webkit-justify-content: center;
        background-image: linear-gradient(180deg, #4967e6 0%, #627bf4 100%);
        -webkit-background-image: linear-gradient(180deg, #4967e6 0%, #627bf4 100%);
        box-shadow: 0 2px 4px 0 #3e5ada;
        -webkit-box-shadow: 0 2px 4px 0 #3e5ada;
    }

    .icon-block img {
        margin: 0px auto;
        width: 86%;
        animation: Rotate-reverse 20s linear infinite;
        -webkit-animation: Rotate-reverse 20s linear infinite;
    }

    .icon-block:first-child {
        top: 0;
        left: 50%;
        transform: translate(-50%, -50%);
        -webkit-transform: translate(-50%, -50%);
    }

    .icon-block:nth-child(2) {
        top: 50%;
        right: 0;
        transform: translate(50%, -50%);
        -webkit-transform: translate(50%, -50%);
    }

    .icon-block:nth-child(3) {
        bottom: 0;
        left: 50%;
        transform: translate(-50%, 50%);
        -webkit-transform: translate(-50%, 50%);
    }

    .icon-block:nth-child(4) {
        top: 50%;
        left: 0;
        transform: translate(-50%, -50%);
        -webkit-transform: translate(-50%, -50%);
    }

    /* circle content */
    .circle {
        animation: circle-rotate 20s linear infinite;
        -webkit-animation: circle-rotate 20s linear infinite;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) rotate(45deg);
        -webkit-transform: translate(-50%, -50%) rotate(45deg);
        width: 75%;
        height: 75%;
        border: 3px solid #6495f2;
        border-radius: 50%;
    }

    .circle .icon-block img {
        animation: img-rotate 20s linear infinite;
        -webkit-animation: img-rotate 20s linear infinite;
    }

    /* center logo */
    .center-logo {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        -webkit-transform: translate(-50%, -50%);
    }

    .center-logo img {
        max-width: 200px;
    }

    /* keyframe animation */

    @keyframes Rotate {
        from {
            transform: rotate(0deg);
        }

        to {
            transform: rotate(360deg);
        }
    }

    @-webkit-keyframes Rotate {
        from {
            -webkit-transform: rotate(0deg);
        }

        to {
            -webkit-transform: rotate(360deg);
        }
    }

    @keyframes Rotate-reverse {
        from {
            transform: rotate(360deg);
        }

        to {
            transform: rotate(0deg);
        }
    }

    @-webkit-keyframes Rotate-reverse {
        from {
            -webkit-transform: rotate(360deg);
        }

        to {
            -webkit-transform: rotate(0deg);
        }
    }

    @keyframes circle-rotate {
        from {
            transform: translate(-50%, -50%) rotate(45deg);
        }

        to {
            transform: translate(-50%, -50%) rotate(405deg);
        }
    }

    @-webkit-keyframes circle-rotate {
        from {
            -webkit-transform: translate(-50%, -50%) rotate(45deg);
        }

        to {
            -webkit-transform: translate(-50%, -50%) rotate(405deg);
        }
    }

    @keyframes img-rotate {
        from {
            transform: rotate(-45deg);
        }

        to {
            transform: rotate(-405deg);
        }
    }

    @-webkit-keyframes img-rotate {
        from {
            -webkit-transform: rotate(-45deg);
        }

        to {
            -webkit-transform: rotate(-405deg);
        }
    }
    </style>
</head>

<body class="body bg-white dark:bg-[#1E293B] text-black"
    x-data="{ page: 'ecommerce', 'loaded': true, 'darkMode': true, 'stickyMenu': false, 'sidebarToggle': false, 'scrollTop': false }"
    x-init="darkMode = JSON.parse(localStorage.getItem('darkMode'));
$watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))"
    :class="{ 'dark text-bodydark bg-boxdark-2': darkMode === true }">


    <div class="bg-white dark:bg-[#1E293B]">
        @include('layouts.navigation')
        <div class="p-4 sm:ml-64 mt-20 bg-white dark:bg-[#1E293B]">



            <!-- Page Heading -->
            @if (isset($header))
            <nav class="flex px-5 py-3 text-gray-700 rounded-lg bg-[#eaeaebf3] dark:bg-[#1E293B]"
                aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="#"
                            class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
                            @yield('svg')
                            {{ $header }}

                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </li>
                    <li class="inline-flex items-center">
                        <a id="previous-page" href="{{ $previous_page ?? 'dashboard' }}"
                            class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white"></a>
                    </li>
                </ol>
            </nav>
            @endif

            <!-- Page Content -->
            <main class="bg-white dark:bg-[#1E293B]">
                {{ $slot }}
            </main>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin=" "></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script> --}}
    {{-- <script src="https://cdn.datatables.net/2.1.7/js/dataTables.js"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-appear/0.1/jquery.appear.js"
        integrity="sha512-gmlF0Cjvx6n5XCLF9NNN+rZwS3X0Xn1vwuk+K0L3B4qve4UI+RVbNt0VynWadl//O0VQ8X47GH55KF9j3kVdUw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/circles/0.0.4/circles.min.js"
        integrity="sha512-b1WwqOM9cYn7+FkAOcEoY+CfteslFr4lZOHjC1Alh75hM9f4sySAa0eO1YG7CoEwOV0j46vZ+aHXBSV64Kqw2g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
    $(document).on('ready', function() {
        // initialization of circles
        $('.js-circle').each(function() {
            var circle = $.HSCore.components.HSCircles.init($(this));
        });
    });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@9.0.3"></script>
    @yield('script')
</body>

</html>