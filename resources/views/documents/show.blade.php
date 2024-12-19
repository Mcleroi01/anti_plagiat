<x-app-layout>
    <x-slot name="header">

        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Détails de la Détection du Plagiat') }}
        </h2>
    </x-slot>


    <div class="container">

        <div class=" py-5 items-end">
            <a href="{{route('generate.pdf',$document->_id)}}"
                class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">Attestation</a>
        </div>
        
        @if ($localResults->isEmpty())
            
        @else
            <x-resultlocal :localResults="$localResults" :document="$document" />
        @endif

        
        @if ($apiResults->isEmpty())
           
        @else
          <x-resultApi :apiResults="$apiResults" :document="$document" />
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




            const getChartOptions = () => {
                return {
                    series: [@json($document->highlightedText->average_similarity)], // Utilisation de la variable averageSimilarity
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


             function highlightPlagiarizedText(text) {
                const regex = /plagiarized_text_pattern/g; // Remplacez par un vrai motif de texte plagé
                return text.replace(regex, (match) => `<span style="color: red;">${match}</span>`);
            }

        </script>
    @endsection


</x-app-layout>
