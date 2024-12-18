 <script>
        document.addEventListener('DOMContentLoaded', function() {
            const errorModal = document.getElementById('errorModal');
            const closeModal = document.getElementById('closeModal');

            // Affiche le modal si le message d'erreur est présent
            if (errorModal) {
                errorModal.style.display = 'flex';
            }

            // Ferme le modal lorsque le bouton est cliqué
            closeModal.addEventListener('click', function() {
                errorModal.style.display = 'none';
            });
        });
    </script>



    <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-tab"
            data-tabs-toggle="#default-tab-content" role="tablist">
            <li class="me-2" role="presentation">



                <button class=" flex items-center gap-2 p-4 border-b-2 rounded-t-lg" id="profile-tab"
                    data-tabs-target="#profile" type="button" role="tab" aria-controls="profile"
                    aria-selected="false">
                    <svg class="w-6 h-6 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd"
                            d="M8 7V2.221a2 2 0 0 0-.5.365L3.586 6.5a2 2 0 0 0-.365.5H8Zm2 0V2h7a2 2 0 0 1 2 2v.126a5.087 5.087 0 0 0-4.74 1.368v.001l-6.642 6.642a3 3 0 0 0-.82 1.532l-.74 3.692a3 3 0 0 0 3.53 3.53l3.694-.738a3 3 0 0 0 1.532-.82L19 15.149V20a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V9h5a2 2 0 0 0 2-2Z"
                            clip-rule="evenodd" />
                        <path fill-rule="evenodd"
                            d="M17.447 8.08a1.087 1.087 0 0 1 1.187.238l.002.001a1.088 1.088 0 0 1 0 1.539l-.377.377-1.54-1.542.373-.374.002-.001c.1-.102.22-.182.353-.237Zm-2.143 2.027-4.644 4.644-.385 1.924 1.925-.385 4.644-4.642-1.54-1.54Zm2.56-4.11a3.087 3.087 0 0 0-2.187.909l-6.645 6.645a1 1 0 0 0-.274.51l-.739 3.693a1 1 0 0 0 1.177 1.176l3.693-.738a1 1 0 0 0 .51-.274l6.65-6.646a3.088 3.088 0 0 0-2.185-5.275Z"
                            clip-rule="evenodd" />
                    </svg>
                    Scanner</button>
            </li>
            <li class="me-2" role="presentation">

                <button
                    class=" flex items-center justify-between gap-2 p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                    id="dashboard-tab" data-tabs-target="#dashboard" type="button" role="tab"
                    aria-controls="dashboard" aria-selected="false">
                    <svg class="w-6 h-6 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 6.025A7.5 7.5 0 1 0 17.975 14H10V6.025Z" />
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13.5 3c-.169 0-.334.014-.5.025V11h7.975c.011-.166.025-.331.025-.5A7.5 7.5 0 0 0 13.5 3Z" />
                    </svg>
                    Result
                    @if (!empty($results))
                        <span class="flex w-3 h-3 me-3 bg-blue-600 rounded-full"></span>
                    @endif
                </button>
            </li>

        </ul>
    </div>
    <div id="default-tab-content">
        <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="dashboard" role="tabpanel"
            aria-labelledby="dashboard-tab">
            @if (isset($averageSimilarity))
                <div class="grid grid-cols-1 md:grid-cols-2 sm:grid-cols-2 gap-10 mb-4">

                    <div class="rounded overflow-hidden shadow-lg">


                        <div class="">

                            <div
                                class=" bg-gray-50 dark:bg-gray-800 p-4 border-b-2 border-gray-200 dark:border-gray-700">
                                <h1>Score humain</h1>
                            </div>

                            <div id="chart"></div>

                        </div>
                        <div class="px-6 py-4 flex flex-row items-center">
                            <p class="dark:text-gray-200 text-gray-800 text-sm">
                                Jcrify a détecté que <em
                                    class="text-xl font-bold text-blue-600">{{ round($averageSimilarity, 2) }}</em> %
                                du texte soumis
                                présente des similarités avec d'autres sources.
                                Veuillez consulter ci-dessous la liste détaillée des cas de plagiat identifiés.
                            </p>

                        </div>

                    </div>

                    <div class="rounded overflow-hidden shadow-lg">


                        <div class="">

                            <div
                                class=" bg-gray-50 dark:bg-gray-800 p-4 border-b-2 border-gray-200 dark:border-gray-700">
                                <h1>Travaux de la base de donnes local</h1>
                            </div>

                            <div id="chart2"></div>

                        </div>
                        <div class="px-6 py-4 flex flex-row items-center">
                            <p class="dark:text-gray-200 text-gray-800 text-sm">
                                Jcrify a détecté que <em
                                    class="text-xl font-bold text-blue-600">{{ round($averageSimilarityLocales, 2) }}</em>
                                %
                                du texte soumis
                                présente des similarités avec d'autres sources.
                                Veuillez consulter ci-dessous la liste détaillée des cas de plagiat identifiés.
                            </p>

                        </div>

                    </div>


                    <div class="rounded overflow-hidden shadow-lg">


                        <div class="">

                            <div
                                class=" bg-gray-50 dark:bg-gray-800 p-4 border-b-2 border-gray-200 dark:border-gray-700">
                                <h1>Score Ai</h1>
                            </div>

                            <div id="chart" class=" p-4">Actuellement, aucun résultat de vérification du plagiat
                                par
                                intelligence artificielle n'est disponible. Cette fonctionnalité sera prochainement
                                intégrée. Merci de votre patience.
                            </div>

                        </div>
                        <div class="px-6 py-4 flex flex-row items-center">
                            <p class="dark:text-gray-200 text-gray-800 text-sm">

                            </p>
                        </div>

                    </div>
                </div>

                <script>
                    const getChartOptions = () => {
                        return {
                            series: [@json($averageSimilarity)], // Utilisation de la variable averageSimilarity
                            colors: ["#1C64F2"], // Couleur du graphique
                            chart: {
                                height: "380px",
                                width: "100%",
                                type: "radialBar",
                                sparkline: {
                                    enabled: true,
                                },
                            },
                            stroke: {
                                colors: ["transparent"],
                                lineCap: "round", // Utilisation de 'round' pour les extrémités de la barre radiale
                            },
                            plotOptions: {
                                radialBar: {
                                    track: {
                                        background: '#E5E7EB',
                                    },
                                    dataLabels: {
                                        show: false,
                                    },
                                    hollow: {
                                        margin: 0,
                                        size: "32%",
                                    },
                                    donut: {
                                        labels: {
                                            show: true,
                                            name: {
                                                show: true,
                                                fontFamily: "Inter, sans-serif",
                                                offsetY: 20,
                                            },
                                            value: {
                                                show: true,
                                                fontFamily: "Inter, sans-serif",
                                                offsetY: -20,
                                                formatter: function(value) {
                                                    return value + "%"; // Afficher la valeur brute avec le symbole %
                                                },
                                            },
                                        },
                                        size: "70%",
                                    },
                                },
                            },
                            grid: {
                                show: false,
                                strokeDashArray: 4,
                                padding: {
                                    left: 2,
                                    right: 2,
                                    top: -23,
                                    bottom: -20,
                                },
                            },
                            labels: ["Similitude moyenne"], // Étiquette pour la série de données
                            dataLabels: {
                                enabled: false,
                            },
                            legend: {
                                show: false, // Désactiver la légende car il n'y a qu'une seule série
                                position: "bottom",
                                fontFamily: "Inter, sans-serif",
                            },
                            tooltip: {
                                enabled: true,
                                x: {
                                    show: false,
                                },
                            },
                            yaxis: {
                                show: false,
                            }
                        }
                    }


                    document.addEventListener('DOMContentLoaded', function() {
                        const options = getChartOptions();
                        const chart = new ApexCharts(document.querySelector("#chart"), options);
                        chart.render();
                    });
                </script>

                <script>
                    const getChartOptions2 = () => {
                        return {
                            series: [@json($averageSimilarityLocales)], // Utilisation de la variable averageSimilarity
                            colors: ["#1C64F2"], // Couleur du graphique
                            chart: {
                                height: "380px",
                                width: "100%",
                                type: "radialBar",
                                sparkline: {
                                    enabled: true,
                                },
                            },
                            stroke: {
                                colors: ["transparent"],
                                lineCap: "round", // Utilisation de 'round' pour les extrémités de la barre radiale
                            },
                            plotOptions: {
                                radialBar: {
                                    track: {
                                        background: '#E5E7EB',
                                    },
                                    dataLabels: {
                                        show: false,
                                    },
                                    hollow: {
                                        margin: 0,
                                        size: "32%",
                                    },
                                    donut: {
                                        labels: {
                                            show: true,
                                            name: {
                                                show: true,
                                                fontFamily: "Inter, sans-serif",
                                                offsetY: 20,
                                            },
                                            value: {
                                                show: true,
                                                fontFamily: "Inter, sans-serif",
                                                offsetY: -20,
                                                formatter: function(value) {
                                                    return value + "%"; // Afficher la valeur brute avec le symbole %
                                                },
                                            },
                                        },
                                        size: "70%",
                                    },
                                },
                            },
                            grid: {
                                show: false,
                                strokeDashArray: 4,
                                padding: {
                                    left: 2,
                                    right: 2,
                                    top: -23,
                                    bottom: -20,
                                },
                            },
                            labels: ["Similitude moyenne"], // Étiquette pour la série de données
                            dataLabels: {
                                enabled: false,
                            },
                            legend: {
                                show: false, // Désactiver la légende car il n'y a qu'une seule série
                                position: "bottom",
                                fontFamily: "Inter, sans-serif",
                            },
                            tooltip: {
                                enabled: true,
                                x: {
                                    show: false,
                                },
                            },
                            yaxis: {
                                show: false,
                            }
                        }
                    }


                    document.addEventListener('DOMContentLoaded', function() {
                        const options2 = getChartOptions2();
                        const chart2 = new ApexCharts(document.querySelector("#chart2"), options2);
                        chart2.render();
                    });
                </script>
            @else
                <p class="dark:text-gray-200 text-gray-800">Aucun segment pertinent trouvé.</p>
            @endif

            <div
                class="grid grid-cols-1 md:grid-cols-1 sm:grid-cols-2 gap-10 items-center dark:text-gray-200 text-gray-800">
                @if (!empty($text))
                    <div>
                        <h1 class="block mb-2 text-xl font-semibold dark:text-gray-200 text-gray-800">Votre texte
                            soumis</h1>
                        <div
                            class="bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-900 shadow-md p-4">
                            <p id="plagiarismText">{!! $text !!} ...</p>
                        </div>
                    </div>
                @endif



                <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
                    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-styled-tab"
                        data-tabs-toggle="#default-styled-tab-content"
                        data-tabs-active-classes="text-purple-600 hover:text-purple-600 dark:text-purple-500 dark:hover:text-purple-500 border-purple-600 dark:border-purple-500"
                        data-tabs-inactive-classes="dark:border-transparent text-gray-500 hover:text-gray-600 dark:text-gray-400 border-gray-100 hover:border-gray-300 dark:border-gray-700 dark:hover:text-gray-300"
                        role="tablist">
                        <li class="me-2" role="presentation">
                            <button class="inline-block p-4 border-b-2 rounded-t-lg" id="profile-styled-tab"
                                data-tabs-target="#styled-profile" type="button" role="tab"
                                aria-controls="profile" aria-selected="false">Profile</button>
                        </li>
                        <li class="me-2" role="presentation">
                            <button
                                class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                                id="dashboard-styled-tab" data-tabs-target="#styled-dashboard" type="button"
                                role="tab" aria-controls="dashboard" aria-selected="false">Dashboard</button>
                        </li>
                        <li class="me-2" role="presentation">
                            <button
                                class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                                id="settings-styled-tab" data-tabs-target="#styled-settings" type="button"
                                role="tab" aria-controls="settings" aria-selected="false">Settings</button>
                        </li>
                        <li role="presentation">
                            <button
                                class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                                id="contacts-styled-tab" data-tabs-target="#styled-contacts" type="button"
                                role="tab" aria-controls="contacts" aria-selected="false">Contacts</button>
                        </li>
                    </ul>
                </div>
                <div id="default-styled-tab-content">
                    <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="styled-profile"
                        role="tabpanel" aria-labelledby="profile-tab">
                        @if (!empty($results))

                            <div>
                                <table id="search-table"
                                    class="w-full text-sm text-left rtl:text-right text-gray-200">
                                    <thead
                                        class="text-xs  uppercase bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-900 dark:text-gray-200 text-gray-800">
                                        <tr>

                                            <th scope="col" class="px-6 py-3">
                                                <span class="flex items-center">
                                                    extrait_résultat
                                                </span>
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                <span class="flex items-center">
                                                    similarité_calculée
                                                </span>
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                <span class="flex items-center">
                                                    Pages
                                                </span>
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                <span class="flex items-center">
                                                    lien_résultat
                                                </span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($results as $result)
                                            <tr
                                                class="bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-900 dark:text-gray-200 text-gray-800">
                                                <th scope="row" class="px-6 py-4 font-medium  whitespace-nowrap ">
                                                    {{ substr($result['result_snippet'], 0, 20) }}</th>
                                                <td class="px-6 py-4">{{ $result['similarity_calculated'] }}%</td>
                                                <td class="px-6 py-4">{{ $result['page_number'] }}</td>
                                                <td class="px-6 py-4"><a href="{{ $result['result_link'] }}"
                                                        target="_blank">{{ $result['result_link'] }}</a></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                    </div>
                </div>

                @endif
            </div>
            <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="styled-dashboard" role="tabpanel"
                aria-labelledby="dashboard-tab">
                @if (!empty($responseLocales))

                    <div>
                        <table id="search-table" class="w-full text-sm text-left rtl:text-right text-gray-200">
                            <thead
                                class="text-xs  uppercase bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-900 dark:text-gray-200 text-gray-800">
                                <tr>

                                    <th scope="col" class="px-6 py-3">
                                        <span class="flex items-center">
                                            extrait_résultat
                                        </span>
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        <span class="flex items-center">
                                            similarité_calculée
                                        </span>
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        <span class="flex items-center">
                                            Pages
                                        </span>
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        <span class="flex items-center">
                                            lien_résultat
                                        </span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($results as $result)
                                    <tr
                                        class="bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-900 dark:text-gray-200 text-gray-800">
                                        <th scope="row" class="px-6 py-4 font-medium  whitespace-nowrap ">
                                            {{ substr($result['result_snippet'], 0, 20) }}</th>
                                        <td class="px-6 py-4">{{ $result['similarity_calculated'] }}%</td>
                                        <td class="px-6 py-4">{{ $result['page_number'] }}</td>
                                        <td class="px-6 py-4"><a href="{{ $result['result_link'] }}"
                                                target="_blank">{{ $result['result_link'] }}</a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
            </div>
        </div>

        @endif
    </div>





     <div class=" py-4 flex items-end">
        <a href="#"
            class="block mb-4 text-white bg-primary hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
            type="button">
            Attestation
        </a>
    </div>
    <div class=" p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab">

        <div class="grid grid-cols-1 md:grid-cols-3 sm:grid-cols-3 gap-10 mb-4">
            @if (isset($averageSimilarity))
                <div class="rounded overflow-hidden shadow-lg">
                    <div class="">
                        <div class=" bg-gray-50 dark:bg-gray-800 p-4 border-b-2 border-gray-200 dark:border-gray-700">
                            <h1>Score humain</h1>
                        </div>

                        <div id="chart"></div>
                    </div>
                    <div class="px-6 py-4 flex flex-row items-center">
                        <p class="dark:text-gray-200 text-gray-800 text-sm">
                            Jcrify a détecté que <em
                                class="text-xl font-bold text-blue-600">{{ round($averageSimilarity, 2) }}</em> % du
                            texte soumis
                            présente des similarités avec d'autres sources.
                            Veuillez consulter ci-dessous la liste détaillée des cas de plagiat identifiés.
                        </p>

                    </div>

                </div>
            @else
                <p class="dark:text-gray-200 text-gray-800">Aucun segment pertinent trouvé.</p>
            @endif

            <div class="rounded overflow-hidden shadow-lg">


                <div class="">

                    <div class=" bg-gray-50 dark:bg-gray-800 p-4 border-b-2 border-gray-200 dark:border-gray-700">
                        <h1>Score Document Local</h1>
                    </div>

                    <div id="chart"></div>

                </div>
                <div class="px-6 py-4 flex flex-row items-center">
                    <p class="dark:text-gray-200 text-gray-800 text-sm">
                        Jcrify a détecté que <em class="text-xl font-bold text-blue-600"></em> % du
                        texte soumis
                        présente des similarités avec d'autres sources.
                        Veuillez consulter ci-dessous la liste détaillée des cas de plagiat identifiés.
                    </p>

                </div>

            </div>

            <div class="rounded overflow-hidden shadow-lg">
                <div class="">

                    <div class=" bg-gray-50 dark:bg-gray-800 p-4 border-b-2 border-gray-200 dark:border-gray-700">
                        <h1>Score Ai</h1>
                    </div>

                    <div id="chart" class=" p-4">Actuellement, aucun résultat de vérification du plagiat par
                        intelligence artificielle n'est disponible. Cette fonctionnalité sera prochainement
                        intégrée. Merci de votre patience.
                    </div>
                </div>
                <div class="px-6 py-4 flex flex-row items-center">
                    <p class="dark:text-gray-200 text-gray-800 text-sm">

                    </p>
                </div>
            </div>
        </div>


        <div
            class="grid grid-cols-1 md:grid-cols-1 sm:grid-cols-2 gap-10 items-center dark:text-gray-200 text-gray-800">
            <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
                <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-styled-tab"
                    data-tabs-toggle="#default-styled-tab-content"
                    data-tabs-active-classes="text-purple-600 hover:text-purple-600 dark:text-purple-500 dark:hover:text-purple-500 border-purple-600 dark:border-purple-500"
                    data-tabs-inactive-classes="dark:border-transparent text-gray-500 hover:text-gray-600 dark:text-gray-400 border-gray-100 hover:border-gray-300 dark:border-gray-700 dark:hover:text-gray-300"
                    role="tablist">
                    <li class="me-2" role="presentation">
                        <button class="inline-block p-4 border-b-2 rounded-t-lg" id="profile-styled-tab"
                            data-tabs-target="#styled-profile" type="button" role="tab" aria-controls="profile"
                            aria-selected="false">Detail Score Humains</button>
                    </li>
                    <li class="me-2" role="presentation">
                        <button
                            class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                            id="dashboard-styled-tab" data-tabs-target="#styled-dashboard" type="button" role="tab"
                            aria-controls="dashboard" aria-selected="false">Dashboard</button>
                    </li>
                    <li class="me-2" role="presentation">
                        <button
                            class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                            id="settings-styled-tab" data-tabs-target="#styled-settings" type="button" role="tab"
                            aria-controls="settings" aria-selected="false">Settings</button>
                    </li>

                </ul>
            </div>
            <div id="default-styled-tab-content">
                <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="styled-profile" role="tabpanel"
                    aria-labelledby="profile-tab">
                    @if (!empty($text))
                        <div>
                            <h1 class="block mb-2 text-xl font-semibold dark:text-gray-200 text-gray-800">Votre texte
                                soumis</h1>
                            <div
                                class="bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-900 shadow-md p-4">
                                <p> {{ substr($text, 0, 1000) }} ...</p>
                            </div>
                        </div>
                    @endif
                    @if (!empty($searchResults))

                        <table id="search-table" class="w-full text-sm text-left rtl:text-right text-gray-200">
                            <thead
                                class="text-xs  uppercase bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-900 dark:text-gray-200 text-gray-800">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Extrait Résultat</th>
                                    <th scope="col" class="px-6 py-3">Similarité Calculée</th>
                                    <th scope="col" class="px-6 py-3">Lien Résultat</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($document->searchResults as $result)
                                    <tr
                                        class="bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-900 dark:text-gray-200 text-gray-800">
                                        <th scope="row" class="px-6 py-4 font-medium  whitespace-nowrap ">
                                            {{ substr($result->result_snippet, 0, 20) }}...</th>
                                        <td class="px-6 py-4">{{ $result->similarity_calculated }}%</td>
                                        <td class="px-6 py-4">
                                            <a href="{{ $result->result_link }}" class="text-blue-500 hover:underline"
                                                target="_blank">
                                                {{ substr($result->result_link, 0, 30) }} ...
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    @endif

                </div>

                <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="styled-dashboard" role="tabpanel"
                    aria-labelledby="dashboard-tab">
                    @if (!empty($text))
                        <div>
                            <h1 class="block mb-2 text-xl font-semibold dark:text-gray-200 text-gray-800">Votre texte
                                soumis</h1>
                            <div
                                class="bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-900 shadow-md p-4">
                                <p> {{ substr($text, 0, 1000) }} ...</p>
                            </div>
                        </div>
                    @endif
                    @if (!empty($searchResults))

                        <table id="search-table" class="w-full text-sm text-left rtl:text-right text-gray-200">
                            <thead
                                class="text-xs  uppercase bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-900 dark:text-gray-200 text-gray-800">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Extrait Résultat</th>
                                    <th scope="col" class="px-6 py-3">Similarité Calculée</th>
                                    <th scope="col" class="px-6 py-3">Lien Résultat</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($document->searchResults as $result)
                                    <tr
                                        class="bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-900 dark:text-gray-200 text-gray-800">
                                        <th scope="row" class="px-6 py-4 font-medium  whitespace-nowrap ">
                                            {{ substr($result->result_snippet, 0, 20) }}...</th>
                                        <td class="px-6 py-4">{{ $result->similarity_calculated }}%</td>
                                        <td class="px-6 py-4">
                                            <a href="{{ $result->result_link }}"
                                                class="text-blue-500 hover:underline" target="_blank">
                                                {{ substr($result->result_link, 0, 30) }} ...
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    @endif

                </div>
            </div>

        </div>



    </div>

    @section('script')
        <script>
            if (document.getElementById("search-table") && typeof simpleDatatables.DataTable !== 'undefined') {
                const dataTable = new simpleDatatables.DataTable("#search-table", {
                    searchable: true,
                    sortable: true
                });
            }
        </script>

        @if (isset($averageSimilarity))
            <script>
                const getChartOptions = () => {
                    return {
                        series: [@json($averageSimilarity)], // Utilisation de la variable averageSimilarity
                        colors: ["#1C64F2"], // Couleur du graphique
                        chart: {
                            height: "380px",
                            width: "100%",
                            type: "radialBar",
                            sparkline: {
                                enabled: true,
                            },
                        },
                        stroke: {
                            colors: ["transparent"],
                            lineCap: "round", // Utilisation de 'round' pour les extrémités de la barre radiale
                        },
                        plotOptions: {
                            radialBar: {
                                track: {
                                    background: '#E5E7EB',
                                },
                                dataLabels: {
                                    show: false,
                                },
                                hollow: {
                                    margin: 0,
                                    size: "32%",
                                },
                                donut: {
                                    labels: {
                                        show: true,
                                        name: {
                                            show: true,
                                            fontFamily: "Inter, sans-serif",
                                            offsetY: 20,
                                        },
                                        value: {
                                            show: true,
                                            fontFamily: "Inter, sans-serif",
                                            offsetY: -20,
                                            formatter: function(value) {
                                                return value + "%"; // Afficher la valeur brute avec le symbole %
                                            },
                                        },
                                    },
                                    size: "70%",
                                },
                            },
                        },
                        grid: {
                            show: false,
                            strokeDashArray: 4,
                            padding: {
                                left: 2,
                                right: 2,
                                top: -23,
                                bottom: -20,
                            },
                        },
                        labels: ["Similitude moyenne"], // Étiquette pour la série de données
                        dataLabels: {
                            enabled: false,
                        },
                        legend: {
                            show: false, // Désactiver la légende car il n'y a qu'une seule série
                            position: "bottom",
                            fontFamily: "Inter, sans-serif",
                        },
                        tooltip: {
                            enabled: true,
                            x: {
                                show: false,
                            },
                        },
                        yaxis: {
                            show: false,
                        }
                    }
                }


                document.addEventListener('DOMContentLoaded', function() {
                    const options = getChartOptions();
                    const chart = new ApexCharts(document.querySelector("#chart"), options);
                    chart.render();
                });
            </script>
        @endif

        <script>
            function highlightPlagiarizedText(text) {
                // Supposons que la fonction detectPlagiarism retourne le texte plagé en rouge
                // et le reste en noir.
                const regex = /plagiarized_text_pattern/g; // Remplacez par un vrai motif de texte plagé
                return text.replace(regex, (match) => `<span style="color: red;">${match}</span>`);
            }

            const uploadBtn = document.getElementById('uploadBtn');
            const loadingSpinner = document.getElementById('hidden-section');

            uploadBtn.addEventListener('click', function() {
                // Affiche le loader
                loadingSpinner.classList.remove('hidden');


            });
            if (document.getElementById("search-table") && typeof simpleDatatables.DataTable !== 'undefined') {
                const dataTable = new simpleDatatables.DataTable("#search-table", {
                    searchable: true,
                    sortable: true
                });
            }
        </script>
    @endsection
   