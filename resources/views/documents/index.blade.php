<x-app-layout>

    @if (isset($error))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">Erreur :</strong>
            <span class="block sm:inline">{{ $error }}</span>
        </div>
    @endif



    <table class="w-full text-sm text-left rtl:text-right text-gray-200" id="search-table">
        <thead
            class="text-xs  uppercase bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-900 dark:text-gray-200 text-gray-800">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Name
                </th>
                <th scope="col" class="px-6 py-3">
                    Fichier
                </th>

                <th scope="col" class="px-6 py-3">
                    createdAt
                </th>
                <th scope="col" class="px-6 py-3">
                    updatedAt
                </th>
                <th scope="col" class="px-6 py-3">
                    Action
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($documents as $i => $item)
                <tr
                    class="bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-900 dark:text-gray-200 text-gray-800">
                    <th scope="row" class="px-6 py-4 font-medium  whitespace-nowrap ">
                        {{ $item->filename }}
                    </th>
                    <td class="px-6 py-4">
                        {{ $item->path }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $item->createdAt }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $item->updatedAt }}
                    </td>
                    <td>

                        <button id="dropdownMenuIconButton" data-dropdown-toggle="dropdownDots{{ $i }}"
                            class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-900 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                            type="button">
                            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="currentColor" viewBox="0 0 4 15">
                                <path
                                    d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z" />
                            </svg>
                        </button>

                        <!-- Dropdown menu -->

                    </td>
                </tr>

                <div id="dropdownDots{{ $i }}"
                    class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                    <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownMenuIconButton">
                        <li>
                            <a href="{{ route('documents.show', $item->id) }}"
                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Detail Result</a>
                        </li>
                        <li>
                            <a href="{{ asset('storage/' . $item->path) }}" target="_blank"
                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Settings</a>
                        </li>
                        <li>
                            <a href="#"
                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Earnings</a>
                        </li>
                    </ul>
                    <div class="py-2">
                        <a href="#"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Separated
                            link</a>
                    </div>
                </div>
            @endforeach

        </tbody>
    </table>


    @section('script')
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@9.0.3"></script>

        <script>
            if (document.getElementById("search-table") && typeof simpleDatatables.DataTable !== 'undefined') {
                const dataTable = new simpleDatatables.DataTable("#search-table", {
                    searchable: true,
                    sortable: false
                });
            }
        </script>
    @endsection

</x-app-layout>
