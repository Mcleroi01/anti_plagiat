<!-- component -->

{{-- <aside
    class="bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-900 dark:text-gray-200 text-gray-800 -translate-x-80 fixed inset-0 z-50 my-4 ml-4 h-[calc(100vh-32px)] w-72 rounded-xl transition-transform duration-300 xl:translate-x-0">
    <div class="relative border-b border-white/20">
        <div class="grid grid-cols-1 gap-6 xl:grid-cols-2 items-center">
            <a class="flex items-center gap-4 py-6 px-8 dark:text-gray-200 text-gray-800" href="#/">
                <h6
                    class="block antialiased text-2xl tracking-normal font-sans  font-semibold leading-relaxed dark:text-gray-200 text-gray-800">
                    JC<span class=" text-blue-400">Rify </span></p>
                </h6>
                <svg class="" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                        d="M7.111 20A3.111 3.111 0 0 1 4 16.889v-12C4 4.398 4.398 4 4.889 4h4.444a.89.89 0 0 1 .89.889v12A3.111 3.111 0 0 1 7.11 20Zm0 0h12a.889.889 0 0 0 .889-.889v-4.444a.889.889 0 0 0-.889-.89h-4.389a.889.889 0 0 0-.62.253l-3.767 3.665a.933.933 0 0 0-.146.185c-.868 1.433-1.581 1.858-3.078 2.12Zm0-3.556h.009m7.933-10.927 3.143 3.143a.889.889 0 0 1 0 1.257l-7.974 7.974v-8.8l3.574-3.574a.889.889 0 0 1 1.257 0Z" />
                </svg>

            </a>

            <button onclick="(() => document.body.classList.toggle('dark'))()"
                class="h-12 w-12 rounded-lg p-2 hover:bg-gray-100 dark:hover:bg-gray-700">

                <!-- Soleil (mode clair) -->
                <svg class="fill-violet-700 block dark:hidden transition-all duration-500 ease-in-out"
                    fill="currentColor" viewBox="0 0 20 20">
                    <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                </svg>

                <!-- Lune (mode sombre) -->
                <svg class="fill-yellow-500 hidden dark:block transition-all duration-500 ease-in-out"
                    fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"
                        fill-rule="evenodd" clip-rule="evenodd"></path>
                </svg>
            </button>

        </div>
        <button data-collapse-toggle="navbar-default" type="button"
            class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
            aria-controls="navbar-default" aria-expanded="false">
            <span class="sr-only">Open main menu</span>
            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 17 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M1 1h15M1 7h15M1 13h15" />
            </svg>
        </button>
    </div>
    <div class="m-4" id="navbar-default">
        <ul class="mb-4 flex flex-col gap-1">
            <li>
                <a aria-current="page" class="active" href="{{ route('dashboard') }}">
                    <button
                        class="middle none font-sans font-bold center transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none text-xs py-3 rounded-lg hover:bg-white/10 active:bg-white/30  active:opacity-[0.85] w-full flex items-center gap-4 px-4 capitalize {{ request()->routeIs('dashboard') ? ' bg-gradient-to-tr from-blue-600 to-blue-400 dark:text-gray-200 text-gray-800' : 'dark:text-gray-200 text-gray-800' }}"
                        type="button">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            aria-hidden="true" class="w-5 h-5 text-inherit">
                            <path
                                d="M11.47 3.84a.75.75 0 011.06 0l8.69 8.69a.75.75 0 101.06-1.06l-8.689-8.69a2.25 2.25 0 00-3.182 0l-8.69 8.69a.75.75 0 001.061 1.06l8.69-8.69z">
                            </path>
                            <path
                                d="M12 5.432l8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 01-.75-.75v-4.5a.75.75 0 00-.75-.75h-3a.75.75 0 00-.75.75V21a.75.75 0 01-.75.75H5.625a1.875 1.875 0 01-1.875-1.875v-6.198a2.29 2.29 0 00.091-.086L12 5.43z">
                            </path>
                        </svg>
                        <p
                            class="block antialiased font-sans text-base leading-relaxed text-inherit font-medium capitalize">
                            dashboard</p>
                    </button>
                </a>
            </li>

            <li>
                <a href="{{ route('documents.index') }}">
                    <button
                        class="middle none font-sans font-bold center transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none text-xs py-3 rounded-lg dark:text-gray-200 text-gray-800 hover:bg-white/10 active:bg-white/30 w-full flex items-center gap-4 px-4 capitalize {{ request()->routeIs('documents.index') ? ' bg-gradient-to-tr from-blue-600 to-blue-400 dark:text-gray-200 text-gray-800' : 'dark:text-gray-200 text-gray-800' }}"
                        type="button">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            aria-hidden="true" class="w-5 h-5 text-inherit">
                            <path fill-rule="evenodd"
                                d="M1.5 5.625c0-1.036.84-1.875 1.875-1.875h17.25c1.035 0 1.875.84 1.875 1.875v12.75c0 1.035-.84 1.875-1.875 1.875H3.375A1.875 1.875 0 011.5 18.375V5.625zM21 9.375A.375.375 0 0020.625 9h-7.5a.375.375 0 00-.375.375v1.5c0 .207.168.375.375.375h7.5a.375.375 0 00.375-.375v-1.5zm0 3.75a.375.375 0 00-.375-.375h-7.5a.375.375 0 00-.375.375v1.5c0 .207.168.375.375.375h7.5a.375.375 0 00.375-.375v-1.5zm0 3.75a.375.375 0 00-.375-.375h-7.5a.375.375 0 00-.375.375v1.5c0 .207.168.375.375.375h7.5a.375.375 0 00.375-.375v-1.5zM10.875 18.75a.375.375 0 00.375-.375v-1.5a.375.375 0 00-.375-.375h-7.5a.375.375 0 00-.375.375v1.5c0 .207.168.375.375.375h7.5zM3.375 15h7.5a.375.375 0 00.375-.375v-1.5a.375.375 0 00-.375-.375h-7.5a.375.375 0 00-.375.375v1.5c0 .207.168.375.375.375zm0-3.75h7.5a.375.375 0 00.375-.375v-1.5A.375.375 0 0010.875 9h-7.5A.375.375 0 003 9.375v1.5c0 .207.168.375.375.375z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <p
                            class="block antialiased font-sans text-base leading-relaxed text-inherit font-medium capitalize">
                            Documents</p>
                    </button>
                </a>
            </li>

            <li>
                <a class="" href="{{ route('documents.create') }}">
                    <button
                        class="middle none font-sans font-bold center transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none text-xs py-3 rounded-lg dark:text-gray-200 text-gray-800 hover:bg-white/10 active:bg-white/30 w-full flex items-center gap-4 px-4 capitalize {{ request()->routeIs('documents.create') ? ' bg-gradient-to-tr from-blue-600 to-blue-400 dark:text-gray-200 text-gray-800' : 'dark:text-gray-200 text-gray-800' }}"
                        type="button">
                        <svg class="" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m8 8-4 4 4 4m8 0 4-4-4-4m-2-3-4 14" />
                        </svg>

                        <p
                            class="block antialiased font-sans text-base leading-relaxed text-inherit font-medium capitalize">
                            Plagiasme</p>
                    </button>
                </a>
            </li>
            @if (Auth::user()->hasRole('super admin'))
                <li>
                    <a class="" href="{{ route('users.index') }}">
                        <button
                            class="middle none font-sans font-bold center transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none text-xs py-3 rounded-lg dark:text-gray-200 text-gray-800 hover:bg-white/10 active:bg-white/30 w-full flex items-center gap-4 px-4 capitalize {{ request()->routeIs('users.index') ? ' bg-gradient-to-tr from-blue-600 to-blue-400 dark:text-gray-200 text-gray-800' : 'dark:text-gray-200 text-gray-800' }}"
                            type="button">
                            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd"
                                    d="M12 4a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm-2 9a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-1a4 4 0 0 0-4-4h-4Z"
                                    clip-rule="evenodd" />
                            </svg>

                            <p
                                class="block antialiased font-sans text-base leading-relaxed text-inherit font-medium capitalize">
                                Users</p>
                        </button>
                    </a>
                </li>
                <li>
                    <a class="" href="#">
                        <button
                            class="middle none font-sans font-bold center transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none text-xs py-3 rounded-lg dark:text-gray-200 text-gray-800 hover:bg-white/10 active:bg-white/30 w-full flex items-center gap-4 px-4 capitalize"
                            type="button">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                aria-hidden="true" class="w-5 h-5 text-inherit">
                                <path fill-rule="evenodd"
                                    d="M5.25 9a6.75 6.75 0 0113.5 0v.75c0 2.123.8 4.057 2.118 5.52a.75.75 0 01-.297 1.206c-1.544.57-3.16.99-4.831 1.243a3.75 3.75 0 11-7.48 0 24.585 24.585 0 01-4.831-1.244.75.75 0 01-.298-1.205A8.217 8.217 0 005.25 9.75V9zm4.502 8.9a2.25 2.25 0 104.496 0 25.057 25.057 0 01-4.496 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <p
                                class="block antialiased font-sans text-base leading-relaxed text-inherit font-medium capitalize">
                                notifactions</p>
                        </button>
                    </a>
                </li>
                <li>
                    <a class="" href="{{ route('admin.roles-permissions') }}">
                        <button
                            class="middle none font-sans font-bold center transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none text-xs py-3 rounded-lg dark:text-gray-200 text-gray-800 hover:bg-white/10 active:bg-white/30 w-full flex items-center gap-4 px-4 capitalize {{ request()->routeIs('admin.roles-permissions') ? ' bg-gradient-to-tr from-blue-600 to-blue-400 dark:text-gray-200 text-gray-800' : 'dark:text-gray-200 text-gray-800' }}"
                            type="button">
                            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="square" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M10 19H5a1 1 0 0 1-1-1v-1a3 3 0 0 1 3-3h2m10 1a3 3 0 0 1-3 3m3-3a3 3 0 0 0-3-3m3 3h1m-4 3a3 3 0 0 1-3-3m3 3v1m-3-4a3 3 0 0 1 3-3m-3 3h-1m4-3v-1m-2.121 1.879-.707-.707m5.656 5.656-.707-.707m-4.242 0-.707.707m5.656-5.656-.707.707M12 8a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>


                            <p
                                class="block antialiased font-sans text-base leading-relaxed text-inherit font-medium capitalize">
                                Settings</p>
                        </button>
                    </a>
                </li>
            @endif

        </ul>
        <ul class="mb-4 flex flex-col gap-1">

        </ul>
    </div>
</aside> --}}



<nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
    <div class="px-3 py-3 lg:px-5 lg:pl-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center justify-start rtl:justify-end">
                <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar"
                    type="button"
                    class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
                    <span class="sr-only">Open sidebar</span>
                    <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path clip-rule="evenodd" fill-rule="evenodd"
                            d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
                        </path>
                    </svg>
                </button>
                <a href="https://flowbite.com" class="flex ms-2 md:me-24">
                    <h6
                        class="block antialiased text-2xl tracking-normal font-sans  font-semibold leading-relaxed dark:text-gray-200 text-gray-800">
                        JC<span class=" text-blue-400">Rify </span></p>
                    </h6>
                    <svg class="" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                            d="M7.111 20A3.111 3.111 0 0 1 4 16.889v-12C4 4.398 4.398 4 4.889 4h4.444a.89.89 0 0 1 .89.889v12A3.111 3.111 0 0 1 7.11 20Zm0 0h12a.889.889 0 0 0 .889-.889v-4.444a.889.889 0 0 0-.889-.89h-4.389a.889.889 0 0 0-.62.253l-3.767 3.665a.933.933 0 0 0-.146.185c-.868 1.433-1.581 1.858-3.078 2.12Zm0-3.556h.009m7.933-10.927 3.143 3.143a.889.889 0 0 1 0 1.257l-7.974 7.974v-8.8l3.574-3.574a.889.889 0 0 1 1.257 0Z" />
                    </svg>
                </a>
            </div>
            <div class="flex items-center">
                <div class="flex items-center ms-3">
                    <div>
                        <button type="button"
                            class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
                            aria-expanded="false" data-dropdown-toggle="dropdown-user">
                            <span class="sr-only">Open user menu</span>
                            <img class="w-8 h-8 rounded-full"
                                src="https://flowbite.com/docs/images/people/profile-picture-5.jpg" alt="user photo">
                        </button>
                    </div>
                    <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow dark:bg-gray-700 dark:divide-gray-600"
                        id="dropdown-user">
                        <div class="px-4 py-3" role="none">
                            <p class="text-sm text-gray-900 dark:text-white" role="none">
                                Neil Sims
                            </p>
                            <p class="text-sm font-medium text-gray-900 truncate dark:text-gray-300" role="none">
                                neil.sims@flowbite.com
                            </p>
                        </div>
                        <ul class="py-1" role="none">
                            <li>
                                <a href="#"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white"
                                    role="menuitem">Dashboard</a>
                            </li>
                            <li>
                                <a href="#"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white"
                                    role="menuitem">Settings</a>
                            </li>
                            <li>
                                <a href="#"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white"
                                    role="menuitem">Earnings</a>
                            </li>
                            <li>
                                <a href="#"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white"
                                    role="menuitem">Sign out</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>

<aside id="logo-sidebar"
    class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700"
    aria-label="Sidebar">
    <div class="h-full px-3 pb-4 overflow-y-auto bg-white dark:bg-gray-800">
        <ul class="space-y-2 font-medium">
            <li>
                <a aria-current="page" class="active" href="{{ route('dashboard') }}">
                    <button
                        class="middle none font-sans font-bold center transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none text-xs py-3 rounded-lg hover:bg-white/10 active:bg-white/30  active:opacity-[0.85] w-full flex items-center gap-4 px-4 capitalize {{ request()->routeIs('dashboard') ? ' bg-gradient-to-tr from-blue-600 to-blue-400 dark:text-gray-200 text-gray-800' : 'dark:text-gray-200 text-gray-800' }}"
                        type="button">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            aria-hidden="true" class="w-5 h-5 text-inherit">
                            <path
                                d="M11.47 3.84a.75.75 0 011.06 0l8.69 8.69a.75.75 0 101.06-1.06l-8.689-8.69a2.25 2.25 0 00-3.182 0l-8.69 8.69a.75.75 0 001.061 1.06l8.69-8.69z">
                            </path>
                            <path
                                d="M12 5.432l8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 01-.75-.75v-4.5a.75.75 0 00-.75-.75h-3a.75.75 0 00-.75.75V21a.75.75 0 01-.75.75H5.625a1.875 1.875 0 01-1.875-1.875v-6.198a2.29 2.29 0 00.091-.086L12 5.43z">
                            </path>
                        </svg>
                        <p
                            class="block antialiased font-sans text-base leading-relaxed text-inherit font-medium capitalize">
                            dashboard</p>
                    </button>
                </a>
            </li>

            <li>
                <a href="{{ route('documents.index') }}">
                    <button
                        class="middle none font-sans font-bold center transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none text-xs py-3 rounded-lg dark:text-gray-200 text-gray-800 hover:bg-white/10 active:bg-white/30 w-full flex items-center gap-4 px-4 capitalize {{ request()->routeIs('documents.index') ? ' bg-gradient-to-tr from-blue-600 to-blue-400 dark:text-gray-200 text-gray-800' : 'dark:text-gray-200 text-gray-800' }}"
                        type="button">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            aria-hidden="true" class="w-5 h-5 text-inherit">
                            <path fill-rule="evenodd"
                                d="M1.5 5.625c0-1.036.84-1.875 1.875-1.875h17.25c1.035 0 1.875.84 1.875 1.875v12.75c0 1.035-.84 1.875-1.875 1.875H3.375A1.875 1.875 0 011.5 18.375V5.625zM21 9.375A.375.375 0 0020.625 9h-7.5a.375.375 0 00-.375.375v1.5c0 .207.168.375.375.375h7.5a.375.375 0 00.375-.375v-1.5zm0 3.75a.375.375 0 00-.375-.375h-7.5a.375.375 0 00-.375.375v1.5c0 .207.168.375.375.375h7.5a.375.375 0 00.375-.375v-1.5zm0 3.75a.375.375 0 00-.375-.375h-7.5a.375.375 0 00-.375.375v1.5c0 .207.168.375.375.375h7.5a.375.375 0 00.375-.375v-1.5zM10.875 18.75a.375.375 0 00.375-.375v-1.5a.375.375 0 00-.375-.375h-7.5a.375.375 0 00-.375.375v1.5c0 .207.168.375.375.375h7.5zM3.375 15h7.5a.375.375 0 00.375-.375v-1.5a.375.375 0 00-.375-.375h-7.5a.375.375 0 00-.375.375v1.5c0 .207.168.375.375.375zm0-3.75h7.5a.375.375 0 00.375-.375v-1.5A.375.375 0 0010.875 9h-7.5A.375.375 0 003 9.375v1.5c0 .207.168.375.375.375z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <p
                            class="block antialiased font-sans text-base leading-relaxed text-inherit font-medium capitalize">
                            Documents</p>
                    </button>
                </a>
            </li>

            <li>
                <a class="" href="{{ route('documents.create') }}">
                    <button
                        class="middle none font-sans font-bold center transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none text-xs py-3 rounded-lg dark:text-gray-200 text-gray-800 hover:bg-white/10 active:bg-white/30 w-full flex items-center gap-4 px-4 capitalize {{ request()->routeIs('documents.create') ? ' bg-gradient-to-tr from-blue-600 to-blue-400 dark:text-gray-200 text-gray-800' : 'dark:text-gray-200 text-gray-800' }}"
                        type="button">
                        <svg class="" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m8 8-4 4 4 4m8 0 4-4-4-4m-2-3-4 14" />
                        </svg>

                        <p
                            class="block antialiased font-sans text-base leading-relaxed text-inherit font-medium capitalize">
                            Plagiasme</p>
                    </button>
                </a>
            </li>
            @if (Auth::user()->hasRole('super admin'))
                <li>
                    <a class="" href="{{ route('users.index') }}">
                        <button
                            class="middle none font-sans font-bold center transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none text-xs py-3 rounded-lg dark:text-gray-200 text-gray-800 hover:bg-white/10 active:bg-white/30 w-full flex items-center gap-4 px-4 capitalize {{ request()->routeIs('users.index') ? ' bg-gradient-to-tr from-blue-600 to-blue-400 dark:text-gray-200 text-gray-800' : 'dark:text-gray-200 text-gray-800' }}"
                            type="button">
                            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd"
                                    d="M12 4a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm-2 9a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-1a4 4 0 0 0-4-4h-4Z"
                                    clip-rule="evenodd" />
                            </svg>

                            <p
                                class="block antialiased font-sans text-base leading-relaxed text-inherit font-medium capitalize">
                                Users</p>
                        </button>
                    </a>
                </li>
                <li>
                    <a class="" href="#">
                        <button
                            class="middle none font-sans font-bold center transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none text-xs py-3 rounded-lg dark:text-gray-200 text-gray-800 hover:bg-white/10 active:bg-white/30 w-full flex items-center gap-4 px-4 capitalize"
                            type="button">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                aria-hidden="true" class="w-5 h-5 text-inherit">
                                <path fill-rule="evenodd"
                                    d="M5.25 9a6.75 6.75 0 0113.5 0v.75c0 2.123.8 4.057 2.118 5.52a.75.75 0 01-.297 1.206c-1.544.57-3.16.99-4.831 1.243a3.75 3.75 0 11-7.48 0 24.585 24.585 0 01-4.831-1.244.75.75 0 01-.298-1.205A8.217 8.217 0 005.25 9.75V9zm4.502 8.9a2.25 2.25 0 104.496 0 25.057 25.057 0 01-4.496 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <p
                                class="block antialiased font-sans text-base leading-relaxed text-inherit font-medium capitalize">
                                notifactions</p>
                        </button>
                    </a>
                </li>
                <li>
                    <a class="" href="{{ route('admin.roles-permissions') }}">
                        <button
                            class="middle none font-sans font-bold center transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none text-xs py-3 rounded-lg dark:text-gray-200 text-gray-800 hover:bg-white/10 active:bg-white/30 w-full flex items-center gap-4 px-4 capitalize {{ request()->routeIs('admin.roles-permissions') ? ' bg-gradient-to-tr from-blue-600 to-blue-400 dark:text-gray-200 text-gray-800' : 'dark:text-gray-200 text-gray-800' }}"
                            type="button">
                            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="square" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M10 19H5a1 1 0 0 1-1-1v-1a3 3 0 0 1 3-3h2m10 1a3 3 0 0 1-3 3m3-3a3 3 0 0 0-3-3m3 3h1m-4 3a3 3 0 0 1-3-3m3 3v1m-3-4a3 3 0 0 1 3-3m-3 3h-1m4-3v-1m-2.121 1.879-.707-.707m5.656 5.656-.707-.707m-4.242 0-.707.707m5.656-5.656-.707.707M12 8a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>


                            <p
                                class="block antialiased font-sans text-base leading-relaxed text-inherit font-medium capitalize">
                                Settings</p>
                        </button>
                    </a>
                </li>
            @endif

            <li class="mx-3.5 mt-4 mb-2">
                <p
                    class="block antialiased font-sans text-sm leading-normal dark:text-gray-200 text-gray-800 font-black uppercase opacity-75">
                    auth pages</p>
            </li>

            <li>
                <a class="" href="{{ route('profile.edit') }}">
                    <button
                        class="middle none font-sans font-bold center transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none text-xs py-3 rounded-lg dark:text-gray-200 text-gray-800 hover:bg-white/10 active:bg-white/30 w-full flex items-center gap-4 px-4 capitalize"
                        type="button">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            aria-hidden="true" class="w-5 h-5 text-inherit">
                            <path
                                d="M6.25 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM3.25 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM19.75 7.5a.75.75 0 00-1.5 0v2.25H16a.75.75 0 000 1.5h2.25v2.25a.75.75 0 001.5 0v-2.25H22a.75.75 0 000-1.5h-2.25V7.5z">
                            </path>
                        </svg>
                        <p
                            class="block antialiased font-sans text-base leading-relaxed text-inherit font-medium capitalize text-left">
                            {{ Auth::user()->name }} <br> {{ Auth::user()->email }}</p>
                    </button>
                </a>
            </li>

            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a :href="route('logout')"
                        class="middle none font-sans font-bold center transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none text-xs py-3 rounded-lg dark:text-gray-200 text-gray-800 hover:bg-white/10 active:bg-white/30 w-full flex items-center gap-4 px-4 capitalize"
                        onclick="event.preventDefault();
                            this.closest('form').submit();">

                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            aria-hidden="true" class="w-5 h-5 text-inherit">
                            <path fill-rule="evenodd"
                                d="M7.5 3.75A1.5 1.5 0 006 5.25v13.5a1.5 1.5 0 001.5 1.5h6a1.5 1.5 0 001.5-1.5V15a.75.75 0 011.5 0v3.75a3 3 0 01-3 3h-6a3 3 0 01-3-3V5.25a3 3 0 013-3h6a3 3 0 013 3V9A.75.75 0 0115 9V5.25a1.5 1.5 0 00-1.5-1.5h-6zm10.72 4.72a.75.75 0 011.06 0l3 3a.75.75 0 010 1.06l-3 3a.75.75 0 11-1.06-1.06l1.72-1.72H9a.75.75 0 010-1.5h10.94l-1.72-1.72a.75.75 0 010-1.06z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <p
                            class="block antialiased font-sans text-base leading-relaxed text-inherit font-medium capitalize">
                            Sign Out</p>


                    </a>
                </form>

            </li>
        </ul>
    </div>
</aside>
