<x-app-layout>
    @if (Auth::user()->hasRole('super admin'))
        <div class=" p-4">

            <div class="">
                <div class="mb-12 grid gap-y-10 gap-x-6 md:grid-cols-2 xl:grid-cols-4">
                    <div
                        class="relative flex flex-col bg-clip-border rounded-xl bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-900 dark:text-gray-200 text-gray-800 shadow-md">
                        <div
                            class="bg-clip-border mx-4 rounded-xl overflow-hidden bg-gradient-to-tr from-blue-600 to-blue-400 dark:text-gray-200 text-gray-800 shadow-blue-500/40 shadow-lg absolute -mt-4 grid h-16 w-16 place-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                aria-hidden="true" class="w-6 h-6 dark:text-gray-200 text-gray-800">
                                <path d="M12 7.5a2.25 2.25 0 100 4.5 2.25 2.25 0 000-4.5z"></path>
                                <path fill-rule="evenodd"
                                    d="M1.5 4.875C1.5 3.839 2.34 3 3.375 3h17.25c1.035 0 1.875.84 1.875 1.875v9.75c0 1.036-.84 1.875-1.875 1.875H3.375A1.875 1.875 0 011.5 14.625v-9.75zM8.25 9.75a3.75 3.75 0 117.5 0 3.75 3.75 0 01-7.5 0zM18.75 9a.75.75 0 00-.75.75v.008c0 .414.336.75.75.75h.008a.75.75 0 00.75-.75V9.75a.75.75 0 00-.75-.75h-.008zM4.5 9.75A.75.75 0 015.25 9h.008a.75.75 0 01.75.75v.008a.75.75 0 01-.75.75H5.25a.75.75 0 01-.75-.75V9.75z"
                                    clip-rule="evenodd"></path>
                                <path
                                    d="M2.25 18a.75.75 0 000 1.5c5.4 0 10.63.722 15.6 2.075 1.19.324 2.4-.558 2.4-1.82V18.75a.75.75 0 00-.75-.75H2.25z">
                                </path>
                            </svg>
                        </div>
                        <div class="p-4 text-right">
                            <p
                                class="block antialiased font-sans text-sm leading-normal font-normal text-blue-gray-600">
                                Today's Money</p>
                            <h4
                                class="block antialiased tracking-normal font-sans text-2xl font-semibold leading-snug text-blue-gray-900">
                                $53k</h4>
                        </div>
                        <div class="border-t border-blue-gray-50 p-4">
                            <p
                                class="block antialiased font-sans text-base leading-relaxed font-normal text-blue-gray-600">
                                <strong class="text-green-500">+55%</strong>&nbsp;than last week
                            </p>
                        </div>
                    </div>
                    <div
                        class="relative flex flex-col bg-clip-border rounded-xl bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-900 dark:text-gray-200 text-gray-800 shadow-md">
                        <div
                            class="bg-clip-border mx-4 rounded-xl overflow-hidden bg-gradient-to-tr from-pink-600 to-pink-400 dark:text-gray-200 text-gray-800 shadow-pink-500/40 shadow-lg absolute -mt-4 grid h-16 w-16 place-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                aria-hidden="true" class="w-6 h-6 dark:text-gray-200 text-gray-800">
                                <path fill-rule="evenodd"
                                    d="M7.5 6a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0zM3.751 20.105a8.25 8.25 0 0116.498 0 .75.75 0 01-.437.695A18.683 18.683 0 0112 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 01-.437-.695z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="p-4 text-right">
                            <p
                                class="block antialiased font-sans text-sm leading-normal font-normal text-blue-gray-600">
                                Today's Users</p>
                            <h4
                                class="block antialiased tracking-normal font-sans text-2xl font-semibold leading-snug text-blue-gray-900">
                                {{ $user->count() }}</h4>
                        </div>
                        <div class="border-t border-blue-gray-50 p-4">
                            <p
                                class="block antialiased font-sans text-base leading-relaxed font-normal text-blue-gray-600">
                                <strong class="text-green-500">+3%</strong>&nbsp;than last month
                            </p>
                        </div>
                    </div>
                    <div
                        class="relative flex flex-col bg-clip-border rounded-xl bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-900 dark:text-gray-200 text-gray-800 shadow-md">
                        <div
                            class="bg-clip-border mx-4 rounded-xl overflow-hidden bg-gradient-to-tr from-green-600 to-green-400 dark:text-gray-200 text-gray-800 shadow-green-500/40 shadow-lg absolute -mt-4 grid h-16 w-16 place-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                aria-hidden="true" class="w-6 h-6 dark:text-gray-200 text-gray-800">
                                <path
                                    d="M6.25 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM3.25 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM19.75 7.5a.75.75 0 00-1.5 0v2.25H16a.75.75 0 000 1.5h2.25v2.25a.75.75 0 001.5 0v-2.25H22a.75.75 0 000-1.5h-2.25V7.5z">
                                </path>
                            </svg>
                        </div>
                        <div class="p-4 text-right">
                            <p
                                class="block antialiased font-sans text-sm leading-normal font-normal text-blue-gray-600">
                                New Clients</p>
                            <h4
                                class="block antialiased tracking-normal font-sans text-2xl font-semibold leading-snug text-blue-gray-900">
                                {{ $usersWithUserRole->count() }}</h4>
                        </div>
                        <div class="border-t border-blue-gray-50 p-4">
                            <p
                                class="block antialiased font-sans text-base leading-relaxed font-normal text-blue-gray-600">
                                <strong class="text-red-500">-2%</strong>&nbsp;than yesterday
                            </p>
                        </div>
                    </div>
                    <div
                        class="relative flex flex-col bg-clip-border rounded-xl bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-900 dark:text-gray-200 text-gray-800 shadow-md">
                        <div
                            class="bg-clip-border mx-4 rounded-xl overflow-hidden bg-gradient-to-tr from-orange-600 to-orange-400 dark:text-gray-200 text-gray-800 shadow-orange-500/40 shadow-lg absolute -mt-4 grid h-16 w-16 place-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                aria-hidden="true" class="w-6 h-6 dark:text-gray-200 text-gray-800">
                                <path
                                    d="M18.375 2.25c-1.035 0-1.875.84-1.875 1.875v15.75c0 1.035.84 1.875 1.875 1.875h.75c1.035 0 1.875-.84 1.875-1.875V4.125c0-1.036-.84-1.875-1.875-1.875h-.75zM9.75 8.625c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-.75a1.875 1.875 0 01-1.875-1.875V8.625zM3 13.125c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v6.75c0 1.035-.84 1.875-1.875 1.875h-.75A1.875 1.875 0 013 19.875v-6.75z">
                                </path>
                            </svg>
                        </div>
                        <div class="p-4 text-right">
                            <p
                                class="block antialiased font-sans text-sm leading-normal font-normal text-blue-gray-600">
                                Sales</p>
                            <h4
                                class="block antialiased tracking-normal font-sans text-2xl font-semibold leading-snug text-blue-gray-900">
                                $103,430</h4>
                        </div>
                        <div class="border-t border-blue-gray-50 p-4">
                            <p
                                class="block antialiased font-sans text-base leading-relaxed font-normal text-blue-gray-600">
                                <strong class="text-green-500">+5%</strong>&nbsp;than yesterday
                            </p>
                        </div>
                    </div>
                </div>


                <div
                    class="mb-4 grid grid-cols-1 gap-6 xl:grid-cols-2 w-full relative  flex-col bg-clip-border rounded-xl  dark:text-gray-200 text-gray-800  overflow-hidden xl:col-span-2">

                    <div
                        class="bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-900 shadow-md">
                        <canvas id="myChart"></canvas>
                    </div>
                    <div
                        class="p-6 overflow-x-scroll px-0 pt-0 pb-2 bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-900 shadow-md">
                        <table class="w-full min-w-[640px] table-auto">
                            <thead>
                                <tr>
                                    <th class="border-b border-blue-gray-50 py-3 px-6 text-left">
                                        <p
                                            class="block antialiased font-sans text-[11px] font-medium uppercase text-blue-gray-400">
                                            companies</p>
                                    </th>
                                    <th class="border-b border-blue-gray-50 py-3 px-6 text-left">
                                        <p
                                            class="block antialiased font-sans text-[11px] font-medium uppercase text-blue-gray-400">
                                            budget</p>
                                    </th>
                                    <th class="border-b border-blue-gray-50 py-3 px-6 text-left">
                                        <p
                                            class="block antialiased font-sans text-[11px] font-medium uppercase text-blue-gray-400">
                                            completion</p>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($usersWithUserRole as $item)
                                    <tr>
                                        <!-- Colonne du nom de l'utilisateur -->
                                        <td class="py-3 px-5 border-b border-blue-gray-50">
                                            <div class="flex items-center gap-4">
                                                <p
                                                    class="block antialiased font-sans text-sm leading-normal text-blue-gray-900 font-bold">
                                                    {{ $item->name }}
                                                </p>
                                            </div>
                                        </td>

                                        <!-- Colonne du nombre de crédits -->
                                        <td class="py-3 px-5 border-b border-blue-gray-50">
                                            <p
                                                class="block antialiased font-sans text-xs font-medium text-blue-gray-600">
                                                {{ $item->credit->monthly_limit ?? 'N/A' }}
                                                <!-- Nombre de crédits restants -->
                                            </p>
                                        </td>

                                        <!-- Colonne exemple (progression ou autre) -->
                                        <td class="py-3 px-5 border-b border-blue-gray-50">
                                            <div class="w-10/12">
                                                <p
                                                    class="antialiased font-sans mb-1 block text-xs font-medium text-blue-gray-600">
                                                    60%
                                                </p>
                                                <div
                                                    class="flex flex-start bg-blue-gray-50 overflow-hidden w-full rounded-sm font-sans text-xs font-medium h-1">
                                                    <div class="flex justify-center items-center h-full bg-gradient-to-tr from-blue-600 to-blue-400 dark:text-gray-200 text-gray-800"
                                                        style="width: 60%;"></div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach




                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </div>
    @endif

    @if (Auth::user()->hasRole('user'))
        <div class="mb-12 grid gap-y-10 gap-x-6 md:grid-cols-2 xl:grid-cols-3">

            <div
                class="relative flex flex-col bg-clip-border rounded-xl bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-900 dark:text-gray-200 text-gray-800 shadow-md">
                <div
                    class="bg-clip-border mx-4 rounded-xl overflow-hidden bg-gradient-to-tr from-pink-600 to-pink-400 dark:text-gray-200 text-gray-800 shadow-pink-500/40 shadow-lg absolute -mt-4 grid h-16 w-16 place-items-center">
                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                        viewBox="0 0 24 24">
                        <path fill-rule="evenodd"
                            d="M7 9v6a4 4 0 0 0 4 4h4a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V9a2 2 0 0 1 2-2h1v2Z"
                            clip-rule="evenodd" />
                        <path fill-rule="evenodd"
                            d="M13 3.054V7H9.2a2 2 0 0 1 .281-.432l2.46-2.87A2 2 0 0 1 13 3.054ZM15 3v4a2 2 0 0 1-2 2H9v6a2 2 0 0 0 2 2h7a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2h-3Z"
                            clip-rule="evenodd" />
                    </svg>

                </div>
                <div class="p-4 text-right">
                    <p class="block antialiased font-sans text-sm leading-normal font-normal text-blue-gray-600">
                        Documents Uploade</p>
                    <h4
                        class="block antialiased tracking-normal font-sans text-2xl font-semibold leading-snug text-blue-gray-900">
                        {{ $documents->count() }}</h4>
                </div>
                <div class="border-t border-blue-gray-50 p-4">
                    <p class="block antialiased font-sans text-base leading-relaxed font-normal text-blue-gray-600">
                        <strong class="text-green-500">+3%</strong>&nbsp;than last month
                    </p>
                </div>
            </div>
            <div
                class="relative flex flex-col bg-clip-border rounded-xl bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-900 dark:text-gray-200 text-gray-800 shadow-md">
                <div
                    class="bg-clip-border mx-4 rounded-xl overflow-hidden bg-gradient-to-tr from-green-600 to-green-400 dark:text-gray-200 text-gray-800 shadow-green-500/40 shadow-lg absolute -mt-4 grid h-16 w-16 place-items-center">
                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                        viewBox="0 0 24 24">
                        <path fill-rule="evenodd"
                            d="M7 6a2 2 0 0 1 2-2h11a2 2 0 0 1 2 2v7a2 2 0 0 1-2 2h-2v-4a3 3 0 0 0-3-3H7V6Z"
                            clip-rule="evenodd" />
                        <path fill-rule="evenodd"
                            d="M2 11a2 2 0 0 1 2-2h11a2 2 0 0 1 2 2v7a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2v-7Zm7.5 1a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5Z"
                            clip-rule="evenodd" />
                        <path d="M10.5 14.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0Z" />
                    </svg>

                </div>
                <div class="p-4 text-right">
                    <p class="block antialiased font-sans text-sm leading-normal font-normal text-blue-gray-600">
                        Nombre de credits</p>
                    <h4
                        class="block antialiased tracking-normal font-sans text-2xl font-semibold leading-snug text-blue-gray-900">
                        @foreach ($credits as $item)
                            {{ $item->monthly_limit }}
                        @endforeach
                    </h4>
                </div>
                <div class="border-t border-blue-gray-50 p-4">
                    <p class="block antialiased font-sans text-base leading-relaxed font-normal text-blue-gray-600">
                        <strong class="text-red-500">-2%</strong>&nbsp;than yesterday
                    </p>
                </div>
            </div>
            <div
                class="relative flex flex-col bg-clip-border rounded-xl bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-900 dark:text-gray-200 text-gray-800 shadow-md">
                <div
                    class="bg-clip-border mx-4 rounded-xl overflow-hidden bg-gradient-to-tr from-orange-600 to-orange-400 dark:text-gray-200 text-gray-800 shadow-orange-500/40 shadow-lg absolute -mt-4 grid h-16 w-16 place-items-center">
                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                        viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                            d="M8 7V6a1 1 0 0 1 1-1h11a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1h-1M3 18v-7a1 1 0 0 1 1-1h11a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1Zm8-3.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z" />
                    </svg>

                </div>
                <div class="p-4 text-right">
                    <p class="block antialiased font-sans text-sm leading-normal font-normal text-blue-gray-600">
                        Credits Utlise</p>
                    <h4
                        class="block antialiased tracking-normal font-sans text-2xl font-semibold leading-snug text-blue-gray-900">
                        @foreach ($credits as $item)
                            {{ $item->documents_uploaded }}
                        @endforeach
                    </h4>
                </div>
                <div class="border-t border-blue-gray-50 p-4">
                    <p class="block antialiased font-sans text-base leading-relaxed font-normal text-blue-gray-600">
                        <strong class="text-green-500">+5%</strong>&nbsp;than yesterday
                    </p>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-900 shadow-md">
            <canvas id="myChart1"></canvas>
        </div>
    @endif


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Données pour le graphique des utilisateurs enregistrés
        const userData = {
            labels: @json($data->map(fn($data) => $data->date)),
            datasets: [{
                label: 'Utilisateurs Enregistrés dans les 30 Derniers Jours',
                backgroundColor: 'rgba(255, 99, 132, 0.3)',
                borderColor: 'rgb(255, 99, 132)',
                data: @json($data->map(fn($data) => $data->aggregate)),
            }]
        };

        const userConfig = {
            type: 'bar',
            data: userData,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Utilisateurs Enregistrés'
                    }
                }
            }
        };

        const userChart = new Chart(
            document.getElementById('myChart'),
            userConfig
        );

        // Données pour le graphique des documents uploadés
        const documentData = {
            labels: @json($documentsUploaded->map(fn($data) => $data->date)),
            datasets: [{
                label: 'Documents Uploadés par Jour',
                backgroundColor: 'rgba(255, 99, 132, 0.3)',
                borderColor: 'rgb(255, 99, 132)',
                borderWidth: 1,
                data: @json($documentsUploaded->map(fn($data) => $data->aggregate)),
            }]
        };

        const documentConfig = {
            type: 'bar',
            data: documentData,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Documents Uploadés'
                    }
                }
            }
        };

        const documentChart = new Chart(
            document.getElementById('myChart1'),
            documentConfig
        );
    </script>


    </script>
</x-app-layout>
