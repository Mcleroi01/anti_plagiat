<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">




        <div
            class="w-full m-10 flex-col mx-auto sm:m-10 flex sm:flex-row mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">

            <div class="lg:w-1/2 xl:w-5/12 p-6 sm:p-12 flex flex-col items-center">
                <div class="mb-6">
                    <a class="flex items-center gap-4 py-6 px-8 text-black" href="#/">
                        <h6
                            class="block antialiased text-4xl tracking-normal font-sans  font-semibold leading-relaxed text-black">
                            JC<span class=" text-blue-400">Rify </span></p>
                        </h6>
                        <svg class="" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                                d="M7.111 20A3.111 3.111 0 0 1 4 16.889v-12C4 4.398 4.398 4 4.889 4h4.444a.89.89 0 0 1 .89.889v12A3.111 3.111 0 0 1 7.11 20Zm0 0h12a.889.889 0 0 0 .889-.889v-4.444a.889.889 0 0 0-.889-.89h-4.389a.889.889 0 0 0-.62.253l-3.767 3.665a.933.933 0 0 0-.146.185c-.868 1.433-1.581 1.858-3.078 2.12Zm0-3.556h.009m7.933-10.927 3.143 3.143a.889.889 0 0 1 0 1.257l-7.974 7.974v-8.8l3.574-3.574a.889.889 0 0 1 1.257 0Z" />
                        </svg>

                    </a>
                </div>
                <div class="flex flex-col items-center w-full">
                    <a href="{{ route('social.login', 'google') }}"
                        class="w-full max-w-xs font-bold shadow-sm rounded-lg py-3 bg-blue-400 text-gray-800 flex items-center justify-center transition-all duration-300 ease-in-out focus:outline-none hover:shadow-lg">
                        <div class="bg-white p-2 rounded-full">
                            <svg class="w-4" viewBox="0 0 533.5 544.3">
                                <path
                                    d="M533.5 278.4c0-18.5-1.5-37.1-4.7-55.3H272.1v104.8h147c-6.1 33.8-25.7 63.7-54.4 82.7v68h87.7c51.5-47.4 81.1-117.4 81.1-200.2z"
                                    fill="#4285f4" />
                                <path
                                    d="M272.1 544.3c73.4 0 135.3-24.1 180.4-65.7l-87.7-68c-24.4 16.6-55.9 26-92.6 26-71 0-131.2-47.9-152.8-112.3H28.9v70.1c46.2 91.9 140.3 149.9 243.2 149.9z"
                                    fill="#34a853" />
                                <path
                                    d="M119.3 324.3c-11.4-33.8-11.4-70.4 0-104.2V150H28.9c-38.6 76.9-38.6 167.5 0 244.4l90.4-70.1z"
                                    fill="#fbbc04" />
                                <path
                                    d="M272.1 107.7c38.8-.6 76.3 14 104.4 40.8l77.7-77.7C405 24.6 339.7-.8 272.1 0 169.2 0 75.1 58 28.9 150l90.4 70.1c21.5-64.5 81.8-112.4 152.8-112.4z"
                                    fill="#ea4335" />
                            </svg>
                        </div>
                        <span class="ml-4">Sign In with Google</span>
                    </a>

                    <div class="my-12 border-b text-center w-full">
                        <div
                            class="leading-none px-2 inline-block text-sm text-gray-600 tracking-wide font-medium bg-white transform translate-y-1/2">
                            Or sign In with Cartesian E-mail
                        </div>
                    </div>

                    <div class="mx-auto max-w-xs w-full">
                        {{ $slot }}
                    </div>
                </div>
            </div>
            <div class="flex-1 text-center hidden lg:flex">
                <div class="m-12 xl:m-16 w-full h-full bg-contain bg-center bg-no-repeat"
                    style="background-image: url('https://static.vecteezy.com/ti/vecteur-libre/p3/8699167-plagiat-idees-illustration-concept-vectoriel.jpg');">
                </div>
            </div>
        </div>


    </div>
</body>

</html>
