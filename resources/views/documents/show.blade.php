<x-app-layout>
    <div class=" p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab">
        @if (isset($averageSimilarity))
            <div class="grid grid-cols-1 md:grid-cols-2 sm:grid-cols-2 gap-10 mb-4">

                <div class="rounded overflow-hidden shadow-lg">


                    <div class="">

                        <div class=" bg-white p-4">
                            <h1>Score humain</h1>
                        </div>

                        <div id="chart"></div>

                    </div>
                    <div class="px-6 py-4 flex flex-row items-center">
                        <p class="dark:text-gray-200 text-gray-800 text-sm">
                            Winston a détecté le texte comme étant <em
                                class=" text-xl font-bold text-blue-600">{{ $averageSimilarity }}</em> % plagié.
                            Veuillez
                            consulter la liste complète des cas de plagiat ci-dessous.
                        </p>
                    </div>

                </div>

                <div class="rounded overflow-hidden shadow-lg">


                    <div class="">

                        <div class=" bg-white p-4">
                            <h1>Score Ai</h1>
                        </div>

                        <div id="chart">Pas de résultat pour la vérification du plagiat par AI pour le moment.
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

                <table id="table" class="min-w-full table-auto border-collapse border border-gray-300">
                    <thead class="bg-gray-100 dark:bg-gray-700">
                        <tr>
                            <th class="px-4 py-2 border border-gray-300">Extrait Résultat</th>
                            <th class="px-4 py-2 border border-gray-300">Similarité Calculée</th>
                            <th class="px-4 py-2 border border-gray-300">Lien Résultat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($searchResults as $result)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="px-4 py-2 border border-gray-300">
                                    {{ substr($result->result_snippet, 0, 20) }}...</td>
                                <td class="px-4 py-2 border border-gray-300">{{ $result->similarity_calculated }}%</td>
                                <td class="px-4 py-2 border border-gray-300">
                                    <a href="{{ $result->result_link }}" class="text-blue-500 hover:underline"
                                        target="_blank">
                                        Voir le résultat
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>


                </tbody>
                </table>
        </div>

        @endif

    </div>
</x-app-layout>
