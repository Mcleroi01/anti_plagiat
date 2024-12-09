<x-app-layout>
    <x-slot name="header">
        
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Détails de la Détection du Plagiat') }}
        </h2>
    </x-slot>
    <div class=" p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="dashboard" role="tabpanel"
        aria-labelledby="dashboard-tab">
        @if (isset($averageSimilarity))
            <div class="grid grid-cols-1 md:grid-cols-2 sm:grid-cols-2 gap-10 mb-4">

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


        </div>

        @endif

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
    @endsection
</x-app-layout>
