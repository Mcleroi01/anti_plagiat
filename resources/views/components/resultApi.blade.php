@props(['apiResults', 'document'])




<div class="grid grid-cols-1 md:grid-cols-2 sm:grid-cols-2 gap-10 mb-4">
    <div class="rounded overflow-hidden shadow-lg">


        <div class="">

            <div class=" bg-gray-50 dark:bg-gray-800 p-4 border-b-2 border-gray-200 dark:border-gray-700">
                <h1>Travaux de la base de donnes local</h1>
            </div>

            <div id="chart"></div>

        </div>
        <div class="px-6 py-4 flex flex-row items-center">
            <p class="dark:text-gray-200 text-gray-800 text-sm">
                Jcrify a détecté que <em
                    class="text-xl font-bold text-blue-600">{{ round($apiResults->avg('similarity_percentage'), 2) }}</em>
                %
                du texte soumis
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

            <div id="chart2" class=" p-4">Actuellement, aucun résultat de vérification du plagiat
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



<div class=" mb-4 dark:text-gray-200 text-gray-800">

    <div>
        <h1 class="block mb-2 text-xl font-semibold dark:text-gray-200 text-gray-800">Votre texte soumis</h1>
        <div class="bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-900 shadow-md p-4">
            <!-- Conteneur pour le texte -->
            <p id="plagiarismText" class="line-clamp-3">
                {!! $document->highlightedText->highlighted_text !!}
            </p>
            <!-- Bouton Voir plus/Voir moins -->
            <button id="toggleTextButton" class="mt-2 text-blue-600 hover:underline">Voir plus</button>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const plagiarismText = document.getElementById('plagiarismText');
            const toggleButton = document.getElementById('toggleTextButton');

            toggleButton.addEventListener('click', function() {
                if (plagiarismText.classList.contains('line-clamp-3')) {
                    plagiarismText.classList.remove('line-clamp-3');
                    toggleButton.textContent = 'Voir moins';
                } else {
                    plagiarismText.classList.add('line-clamp-3');
                    toggleButton.textContent = 'Voir plus';
                }
            });
        });
    </script>

    <style>
        .line-clamp-3 {
            overflow: hidden;
            display: -webkit-box;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 3;
            /* Nombre de lignes affichées */
        }
    </style>


</div>


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
            @foreach ($apiResults as $result)
                <tr
                    class="bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-900 dark:text-gray-200 text-gray-800">
                    <th scope="row" class="px-6 py-4 font-medium  whitespace-nowrap ">
                        {{ substr($result->search_phrase, 0, 50) }}</th>
                    <td class="px-6 py-4">{{ $result->similarity_calculated }}%</td>
                    <td class="px-6 py-4">{{ $result->page_number }}</td>
                    <td class="px-6 py-4">{{ substr($result->result_snippet, 0, 50) }}</td>
                    <td class="px-6 py-4">
                        <a href="{{ $result->result_link }}" class="text-blue-500 hover:underline" target="_blank">
                            {{ substr($result->result_link, 0, 30) }} ...
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>


</div>
