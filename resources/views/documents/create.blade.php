<x-app-layout>
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-red-400"
                role="alert">
                <span class="font-medium">{{ $error }}</span>
            </div>
        @endforeach
    @endif

    @if (session('error'))
        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-red-400"
            role="alert">
            <span class="font-medium">{{ session('error') }}</span>
        </div>
    @endif

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
                    Result</button>
            </li>

        </ul>
    </div>
    <div id="default-tab-content">


        <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="profile" role="tabpanel"
            aria-labelledby="profile-tab">
            <form action="{{ route('documents.create') }}" method="POST" enctype="multipart/form-data" class="">
                @csrf
                <label for="document" class="block mb-2 text-xl font-semibold text-white">Télécharger un document
                    :</label>
                <div class="mb-5">
                    <div class="flex items-center justify-center w-full">
                        <label for="dropzone-file"
                            class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-700 border-dashed rounded-lg cursor-pointer bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-900 dark:text-gray-200 text-gray-800 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                </svg>
                                <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span
                                        class="font-semibold">Click to
                                        upload</span> or drag and drop</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or GIF (MAX.
                                    800x400px)</p>
                            </div>
                            <input id="dropzone-file" type="file" class="hidden" name="document" required />
                        </label>
                    </div>
                </div>

                <button type="submit" id="uploadBtn"
                    class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">Uploader</button>
            </form>
        </div>



        <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="dashboard" role="tabpanel"
            aria-labelledby="dashboard-tab">
            @if (isset($averageSimilarity))
                <div class="grid grid-cols-1 md:grid-cols-1 sm:grid-cols-2 gap-10 mb-4">

                    <div class="rounded overflow-hidden shadow-lg">


                        <div class="">

                            <div class=" bg-white p-4">
                                <h1>Score humain</h1>
                            </div>

                            <div id="chart"></div>

                        </div>
                        <div class="px-6 py-4 flex flex-row items-center">
                            <p class="dark:text-gray-200 text-gray-800 text-sm">
                                Winston a détecté le texte comme étant {{ $averageSimilarity }} % plagié. Veuillez
                                consulter la liste complète des cas de plagiat ci-dessous.
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
                class="grid grid-cols-1 md:grid-cols-2 sm:grid-cols-2 gap-10 items-center dark:text-gray-200 text-gray-800">
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
                @if (!empty($results))
                    @foreach ($results as $result)
                        <div>
                            <div
                                class="block items-center justify-center p-5 text-base font-medium text-gray-500 rounded-lg bg-gray-50 hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700 dark:hover:text-white">
                                <div class="w-10/12">
                                    <p class="antialiased font-sans mb-1 block text-xs font-medium text-blue-gray-600">
                                        {{ $result['similarity_calculated'] }}%
                                    </p>
                                    <div
                                        class="flex flex-start bg-blue-gray-50 overflow-hidden w-full rounded-sm font-sans text-xs font-medium h-1">
                                        <div class="flex justify-center items-center h-full bg-gradient-to-tr from-blue-600 to-blue-400 dark:text-gray-200 text-gray-800"
                                            style="width: 60%;"></div>
                                    </div>
                                </div>
                                <div class="flex items-center gap-4">
                                    <p
                                        class="block antialiased font-sans text-sm leading-normal text-blue-gray-900 font-bold">
                                        {{ substr($result['search_phrase'], 0, 20) }}
                                    </p>
                                </div>
                                <div>
                                    <p class="block antialiased font-sans text-xs font-medium text-blue-gray-600">
                                        <a href="{{ $result['result_link'] }}"
                                            target="_blank">{{ $result['result_link'] }}</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    </tbody>
                    </table>
            </div>

            @endif

        </div>

    </div>

    </div>








    <div class="fixed inset-0 z-50 flex justify-center items-center bg-black bg-opacity-50 hidden"
        id="hidden-section">
        <div class="flex justify-center items-center relative">
            <!-- Cercle extérieur gris -->
            <div class="h-24 w-24 rounded-full border-t-8 border-b-8 border-gray-200"></div>
            <!-- Cercle intérieur bleu avec animation -->
            <div
                class="absolute top-0 left-0 h-24 w-24 rounded-full border-t-8 border-b-8 border-blue-500 animate-spin">
            </div>
        </div>
    </div>

    @section('script')
        <script>
            const uploadBtn = document.getElementById('uploadBtn');
            const loadingSpinner = document.getElementById('hidden-section');

            uploadBtn.addEventListener('click', function() {
                // Affiche le loader
                loadingSpinner.classList.remove('hidden');


            });
        </script>
    @endsection

</x-app-layout>
