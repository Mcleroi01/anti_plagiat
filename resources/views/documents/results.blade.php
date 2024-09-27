<x-app-layout>
    <div class="container">
        <h2>Résultats de Similarité</h2>

        @if (isset($results) && count($results) > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th>Phrase recherchée</th>
                        <th>Extrait du résultat</th>
                        <th>Similarité calculée (%)</th>
                        <th>Lien du résultat</th>
                        <th>Similarité globale (%)</th>
                    </tr>
                </thead>
                <tbody>

                    <tr>
                        <td>{{ $results['search_phrase'] }}</td>
                        <td>{{ $results['result_snippet'] }}</td>
                        <td>{{ $results['similarity_calculated'] }}</td>
                        <td><a href="{{ $results['result_link'] }}" target="_blank">Voir le lien</a></td>
                        <td>{{ $results['global_similarity_calculated'] }}</td>
                    </tr>

                </tbody>
            </table>
        @else
            <p>Aucun résultat trouvé.</p>
        @endif
    </div>


    <div class="mb-4 grid grid-cols-1 gap-6 xl:grid-cols-3">
        <div
            class="relative flex flex-col bg-clip-border rounded-xl bg-gradient-to-br from-gray-800 to-gray-900 text-gray-200 shadow-md overflow-hidden xl:col-span-2">
            <div
                class="relative bg-clip-border rounded-xl overflow-hidden bg-transparent text-gray-200 shadow-none m-0 flex items-center justify-between p-6">
                <div>
                    <h6
                        class="block antialiased tracking-normal font-sans text-base font-semibold leading-relaxed text-blue-gray-900 mb-1">
                        Projects</h6>
                    <p
                        class="antialiased font-sans text-sm leading-normal flex items-center gap-1 font-normal text-blue-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3"
                            stroke="currentColor" aria-hidden="true" class="h-4 w-4 text-blue-500">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"></path>
                        </svg>
                        <strong>{{$searchResults->count()}} done</strong> this month
                    </p>
                </div>
                <button aria-expanded="false" aria-haspopup="menu"
                    class="relative middle none font-sans font-medium text-center uppercase transition-all w-8 max-w-[32px] h-8 max-h-[32px] rounded-lg text-xs text-blue-gray-500 hover:bg-blue-gray-500/10 active:bg-blue-gray-500/30"
                    type="button">
                    <span class="absolute top-1/2 left-1/2 transform -translate-y-1/2 -translate-x-1/2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currenColor" viewBox="0 0 24 24" stroke-width="3"
                            stroke="currentColor" aria-hidden="true" class="h-6 w-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 18.75a.75.75 0 110-1.5.75.75 0 010 1.5z">
                            </path>
                        </svg>
                    </span>
                </button>
            </div>
            <div class="p-6 overflow-x-scroll px-0 pt-0 pb-2">
                <table class="w-full min-w-[640px] table-auto">
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
                        @foreach ($searchResults as $item)
                            <tr>
                                <td class="py-3 px-5 border-b border-blue-gray-50">
                                    <div class="flex items-center gap-4">
                                        <p
                                            class="block antialiased font-sans text-sm leading-normal text-blue-gray-900 font-bold">
                                            {{ $item->search_phrase }}
                                        </p>
                                    </div>
                                </td>
                                <td class="py-3 px-5 border-b border-blue-gray-50">
                                    <p class="block antialiased font-sans text-xs font-medium text-blue-gray-600">
                                        {{ $item->result_snippet }}
                                    </p>
                                </td>
                                <td class="py-3 px-5 border-b border-blue-gray-50">
                                    <div class="w-10/12">
                                        <p
                                            class="antialiased font-sans mb-1 block text-xs font-medium text-blue-gray-600">
                                            {{ $item->similarity_calculated }}%
                                        </p>
                                        <div
                                            class="flex flex-start bg-blue-gray-50 overflow-hidden w-full rounded-sm font-sans text-xs font-medium h-1">
                                            <div class="flex justify-center items-center h-full bg-gradient-to-tr from-blue-600 to-blue-400 text-white"
                                                style="width: {{ $item->similarity_calculated }}%;"></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 px-5 border-b border-blue-gray-50">
                                    <a href="{{ $item->result_link }}"
                                        class="block antialiased font-sans text-xs font-medium text-blue-gray-600"
                                        target="_blank">Voir</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>



</x-app-layout>
