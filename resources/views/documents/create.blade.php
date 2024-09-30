<x-app-layout>
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-red-400"
                role="alert">
                <span class="font-medium">{{ $error }}</span>
            </div>
        @endforeach
    @endif

    <form action="{{ route('documents.create') }}" method="POST" enctype="multipart/form-data" class=" p-10">
        @csrf
        <label for="document" class="block mb-2 text-xl font-semibold text-white">Télécharger un document :</label>
        <div class="mb-5">
            <div class="flex items-center justify-center w-full">
                <label for="dropzone-file"
                    class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-700 border-dashed rounded-lg cursor-pointer bg-gradient-to-br from-gray-800 to-gray-900 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                        <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                        </svg>
                        <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to
                                upload</span> or drag and drop</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or GIF (MAX. 800x400px)</p>
                    </div>
                    <input id="dropzone-file" type="file" class="hidden" name="document" required />
                </label>
            </div>
        </div>

        <button type="submit" id="uploadBtn"
            class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">Uploader</button>
    </form>


    <!-- Section masquée -->
    <section id="hidden-section"
        class="main-container overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full"
        style="display:none;">
        <div class="main relative p-4 w-full max-w-2xl max-h-full">
            <div class="big-circle">
                <div class="icon-block">
                    <img src="https://www.yudiz.com/codepen/animated-portfolio/web-dev-icon.png"
                        alt="web design icon" />
                </div>
                <div class="icon-block">
                    <img src="https://www.yudiz.com/codepen/animated-portfolio/game-design-icon.png"
                        alt="game design icon" />
                </div>
                <div class="icon-block">
                    <img src="https://www.yudiz.com/codepen/animated-portfolio/game-dev-icon.png" alt="game dev icon" />
                </div>
                <div class="icon-block">
                    <img src="https://www.yudiz.com/codepen/animated-portfolio/ui-ux-icon.png" alt="ui-ux icon" />
                </div>
            </div>
            <div class="circle">
                <div class="icon-block">
                    <img src="https://www.yudiz.com/codepen/animated-portfolio/app-icon.png" alt="app icon" />
                </div>
                <div class="icon-block">
                    <img src="https://www.yudiz.com/codepen/animated-portfolio/blockchain-icon.png"
                        alt="blockchain icon" />
                </div>
                <div class="icon-block">
                    <img src="https://www.yudiz.com/codepen/animated-portfolio/arvr-icon.png" alt="ar-vr icon" />
                </div>
                <div class="icon-block">
                    <img src="https://www.yudiz.com/codepen/animated-portfolio/artificial-intelligence-icon.png"
                        alt="artificial intelligence icon" />
                </div>
            </div>
            <div class="center-logo">
                <img src="" alt="logo" />
            </div>
        </div>
    </section>


    @if (isset($averageSimilarity))
        <div class="mt-4 w-full">
            <!-- component -->
            <!-- component -->
            <div class="flex justify-center items-center min-h-screen">
                <div class="max-w-[720px] mx-auto">


                    <!-- Centering wrapper -->
                    <div
                        class="relative flex w-full max-w-[26rem] flex-col rounded-xl bg-gradient-to-br from-gray-800 to-gray-900 text-gray-200 shadow-lg">
                        <div
                            class=" mx-4 mt-4 overflow-hidden text-white shadow-lg rounded-xl bg-blue-gray-500 bg-clip-border shadow-blue-gray-500/40">
                            <div id="chart"></div>
                        </div>
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-3">
                                <h5
                                    class="block font-sans text-xl antialiased font-medium leading-snug tracking-normal text-blue-gray-900">
                                    {{ $averageSimilarity }} %
                                </h5>
                                <p
                                    class="flex items-center gap-1.5 font-sans text-base font-normal leading-relaxed text-blue-gray-900 antialiased">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                        class="-mt-0.5 h-5 w-5 text-yellow-700">
                                        <path fill-rule="evenodd"
                                            d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    5.0
                                </p>
                            </div>
                            <div class="inline-flex flex-wrap items-center gap-3 mt-8 group">
                                <span
                                    class="cursor-pointer rounded-full border border-gray-200 from-gray-800 to-gray-900 text-gray-200 transition-colors hover:border-gray-900/10 hover:bg-gray-900/10 hover:!opacity-100 group-hover:opacity-70">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                        class="w-5 h-5">
                                        <path d="M12 7.5a2.25 2.25 0 100 4.5 2.25 2.25 0 000-4.5z"></path>
                                        <path fill-rule="evenodd"
                                            d="M1.5 4.875C1.5 3.839 2.34 3 3.375 3h17.25c1.035 0 1.875.84 1.875 1.875v9.75c0 1.036-.84 1.875-1.875 1.875H3.375A1.875 1.875 0 011.5 14.625v-9.75zM8.25 9.75a3.75 3.75 0 117.5 0 3.75 3.75 0 01-7.5 0zM18.75 9a.75.75 0 00-.75.75v.008c0 .414.336.75.75.75h.008a.75.75 0 00.75-.75V9.75a.75.75 0 00-.75-.75h-.008zM4.5 9.75A.75.75 0 015.25 9h.008a.75.75 0 01.75.75v.008a.75.75 0 01-.75.75H5.25a.75.75 0 01-.75-.75V9.75z"
                                            clip-rule="evenodd"></path>
                                        <path
                                            d="M2.25 18a.75.75 0 000 1.5c5.4 0 10.63.722 15.6 2.075 1.19.324 2.4-.558 2.4-1.82V18.75a.75.75 0 00-.75-.75H2.25z">
                                        </path>
                                    </svg>
                                </span>
                                <span
                                    class="cursor-pointer rounded-full border border-gray-200 from-gray-800 to-gray-900 text-gray-200 transition-colors hover:border-gray-900/10 hover:bg-gray-900/10 hover:!opacity-100 group-hover:opacity-70">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                        class="w-5 h-5">
                                        <path fill-rule="evenodd"
                                            d="M1.371 8.143c5.858-5.857 15.356-5.857 21.213 0a.75.75 0 010 1.061l-.53.53a.75.75 0 01-1.06 0c-4.98-4.979-13.053-4.979-18.032 0a.75.75 0 01-1.06 0l-.53-.53a.75.75 0 010-1.06zm3.182 3.182c4.1-4.1 10.749-4.1 14.85 0a.75.75 0 010 1.061l-.53.53a.75.75 0 01-1.062 0 8.25 8.25 0 00-11.667 0 .75.75 0 01-1.06 0l-.53-.53a.75.75 0 010-1.06zm3.204 3.182a6 6 0 018.486 0 .75.75 0 010 1.061l-.53.53a.75.75 0 01-1.061 0 3.75 3.75 0 00-5.304 0 .75.75 0 01-1.06 0l-.53-.53a.75.75 0 010-1.06zm3.182 3.182a1.5 1.5 0 012.122 0 .75.75 0 010 1.061l-.53.53a.75.75 0 01-1.061 0l-.53-.53a.75.75 0 010-1.06z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </span>
                                <span
                                    class="cursor-pointer rounded-full border border-gray-200 from-gray-800 to-gray-900 text-gray-200 transition-colors hover:border-gray-900/10 hover:bg-gray-900/10 hover:!opacity-100 group-hover:opacity-70">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                        class="w-5 h-5">
                                        <path
                                            d="M11.47 3.84a.75.75 0 011.06 0l8.69 8.69a.75.75 0 101.06-1.06l-8.689-8.69a2.25 2.25 0 00-3.182 0l-8.69 8.69a.75.75 0 001.061 1.06l8.69-8.69z">
                                        </path>
                                        <path
                                            d="M12 5.432l8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 01-.75-.75v-4.5a.75.75 0 00-.75-.75h-3a.75.75 0 00-.75.75V21a.75.75 0 01-.75.75H5.625a1.875 1.875 0 01-1.875-1.875v-6.198a2.29 2.29 0 00.091-.086L12 5.43z">
                                        </path>
                                    </svg>
                                </span>
                                <span
                                    class="cursor-pointer rounded-full border border-gray-200 from-gray-800 to-gray-900 text-gray-200 transition-colors hover:border-gray-900/10 hover:bg-gray-900/10 hover:!opacity-100 group-hover:opacity-70">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                        class="w-5 h-5">
                                        <path d="M19.5 6h-15v9h15V6z"></path>
                                        <path fill-rule="evenodd"
                                            d="M3.375 3C2.339 3 1.5 3.84 1.5 4.875v11.25C1.5 17.16 2.34 18 3.375 18H9.75v1.5H6A.75.75 0 006 21h12a.75.75 0 000-1.5h-3.75V18h6.375c1.035 0 1.875-.84 1.875-1.875V4.875C22.5 3.839 21.66 3 20.625 3H3.375zm0 13.5h17.25a.375.375 0 00.375-.375V4.875a.375.375 0 00-.375-.375H3.375A.375.375 0 003 4.875v11.25c0 .207.168.375.375.375z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </span>
                                <span
                                    class="cursor-pointer rounded-full border border-gray-200 from-gray-800 to-gray-900 text-gray-200 transition-colors hover:border-gray-900/10 hover:bg-gray-900/10 hover:!opacity-100 group-hover:opacity-70">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                        class="w-5 h-5">
                                        <path fill-rule="evenodd"
                                            d="M12.963 2.286a.75.75 0 00-1.071-.136 9.742 9.742 0 00-3.539 6.177A7.547 7.547 0 016.648 6.61a.75.75 0 00-1.152-.082A9 9 0 1015.68 4.534a7.46 7.46 0 01-2.717-2.248zM15.75 14.25a3.75 3.75 0 11-7.313-1.172c.628.465 1.35.81 2.133 1a5.99 5.99 0 011.925-3.545 3.75 3.75 0 013.255 3.717z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </span>
                                <span
                                    class="cursor-pointer rounded-full border border-gray-200 from-gray-800 to-gray-900 text-gray-200 transition-colors hover:border-gray-900/10 hover:bg-gray-900/10 hover:!opacity-100 group-hover:opacity-70">
                                    +20
                                </span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            @if (!empty($results))
                <h4 class="block font-sans text-xl antialiased font-medium leading-snug tracking-normal text-blue-gray-900 text-gray-200">Détails du Fichier</h4>


                <div class="mb-4 grid grid-cols-1 gap-6 xl:grid-cols-3 w-full">
                    <div
                        class="relative w-full flex flex-col bg-clip-border rounded-xl bg-gradient-to-br from-gray-800 to-gray-900 text-gray-200 shadow-md overflow-hidden xl:col-span-2">
                        <div
                            class="relative bg-clip-border rounded-xl overflow-hidden bg-transparent text-gray-200 shadow-none m-0 flex items-center justify-between p-6">
                            <div>
                                <h6
                                    class="block antialiased tracking-normal font-sans text-base font-semibold leading-relaxed text-blue-gray-900 mb-1">
                                    Projects</h6>
                                <p
                                    class="antialiased font-sans text-sm leading-normal flex items-center gap-1 font-normal text-blue-gray-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="3" stroke="currentColor" aria-hidden="true"
                                        class="h-4 w-4 text-blue-500">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M4.5 12.75l6 6 9-13.5">
                                        </path>
                                    </svg>
                                    <strong>{{ $averageSimilarity }} %</strong>
                                </p>
                            </div>
                            <button aria-expanded="false" aria-haspopup="menu"
                                class="relative middle none font-sans font-medium text-center uppercase transition-all w-8 max-w-[32px] h-8 max-h-[32px] rounded-lg text-xs text-blue-gray-500 hover:bg-blue-gray-500/10 active:bg-blue-gray-500/30"
                                type="button">
                                <span class="absolute top-1/2 left-1/2 transform -translate-y-1/2 -translate-x-1/2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="currenColor" viewBox="0 0 24 24"
                                        stroke-width="3" stroke="currentColor" aria-hidden="true" class="h-6 w-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 18.75a.75.75 0 110-1.5.75.75 0 010 1.5z">
                                        </path>
                                    </svg>
                                </span>
                            </button>
                        </div>
                        <div class="p-6 overflow-x-scroll px-0 pt-0 pb-2">
                            <table class="w-full  table-auto">
                                <thead>
                                    <tr>
                                        <th class="border-b border-blue-gray-50 py-3 px-6 text-left">
                                            <p
                                                class="block antialiased font-sans text-[11px] font-medium uppercase text-blue-gray-400">
                                                Phrase recherchée</p>
                                        </th>
                                        <th class="border-b border-blue-gray-50 py-3 px-6 text-left">
                                            <p
                                                class="block antialiased font-sans text-[11px] font-medium uppercase text-blue-gray-400">
                                                Extrait du résultat</p>
                                        </th>
                                        <th class="border-b border-blue-gray-50 py-3 px-6 text-left">
                                            <p
                                                class="block antialiased font-sans text-[11px] font-medium uppercase text-blue-gray-400">
                                                Similarité calculée (%)</p>
                                        </th>
                                        <th class="border-b border-blue-gray-50 py-3 px-6 text-left">
                                            <p
                                                class="block antialiased font-sans text-[11px] font-medium uppercase text-blue-gray-400">
                                                Lien du résultat</p>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($results as $result)
                                        <tr>
                                            <td class="py-3 px-5 border-b border-blue-gray-50">
                                                <div class="flex items-center gap-4">
                                                    <p
                                                        class="block antialiased font-sans text-sm leading-normal text-blue-gray-900 font-bold">
                                                        {{ $result['search_phrase'] }}
                                                    </p>
                                                </div>
                                            </td>
                                            <td class="py-3 px-5 border-b border-blue-gray-50">
                                                <p
                                                    class="block antialiased font-sans text-xs font-medium text-blue-gray-600">
                                                    {{ $result['result_snippet'] }}
                                                </p>
                                            </td>
                                            <td class="py-3 px-5 border-b border-blue-gray-50">
                                                <div class="w-10/12">
                                                    <p
                                                        class="antialiased font-sans mb-1 block text-xs font-medium text-blue-gray-600">
                                                        {{ $result['similarity_calculated'] }}%
                                                    </p>
                                                    <div
                                                        class="flex flex-start bg-blue-gray-50 overflow-hidden w-full rounded-sm font-sans text-xs font-medium h-1">
                                                        <div class="flex justify-center items-center h-full bg-gradient-to-tr from-blue-600 to-blue-400 text-white"
                                                            style="width: {{ $result['similarity_calculated'] }}%;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-3 px-5 border-b border-blue-gray-50">
                                                <a href="{{ $result['result_link'] }}"
                                                    class="block antialiased font-sans text-xs font-medium text-blue-gray-600"
                                                    target="_blank">{{ $result['result_link'] }}</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @else
                <p>Aucun segment pertinent trouvé.</p>
            @endif
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


    @endif



    @section('script')
        <script>
            const uploadBtn = document.getElementById('uploadBtn');
            const loadingSpinner = document.getElementById('hidden-section');

            uploadBtn.addEventListener('click', function() {
                loadingSpinner.style.display = 'flex';

            });
        </script>
    @endsection

</x-app-layout>
