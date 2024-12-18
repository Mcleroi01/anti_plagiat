<x-app-layout>

    @if (isset($error))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">Erreur :</strong>
            <span class="block sm:inline">{{ $error }}</span>
        </div>
    @endif

    <div class="flex justify-end md:justify-end mb-4">

        <button id="gridViewBtn" class="px-4 py-2 text-black dark:text-gray-100 rounded-lg text-6xl">
            <svg class="" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                fill="currentColor" viewBox="0 0 24 24">
                <path fill-rule="evenodd"
                    d="M4.857 3A1.857 1.857 0 0 0 3 4.857v4.286C3 10.169 3.831 11 4.857 11h4.286A1.857 1.857 0 0 0 11 9.143V4.857A1.857 1.857 0 0 0 9.143 3H4.857Zm10 0A1.857 1.857 0 0 0 13 4.857v4.286c0 1.026.831 1.857 1.857 1.857h4.286A1.857 1.857 0 0 0 21 9.143V4.857A1.857 1.857 0 0 0 19.143 3h-4.286Zm-10 10A1.857 1.857 0 0 0 3 14.857v4.286C3 20.169 3.831 21 4.857 21h4.286A1.857 1.857 0 0 0 11 19.143v-4.286A1.857 1.857 0 0 0 9.143 13H4.857Zm10 0A1.857 1.857 0 0 0 13 14.857v4.286c0 1.026.831 1.857 1.857 1.857h4.286A1.857 1.857 0 0 0 21 19.143v-4.286A1.857 1.857 0 0 0 19.143 13h-4.286Z"
                    clip-rule="evenodd" />
            </svg>

        </button>
        <button id="listViewBtn" class="px-4 py-2 text-black dark:text-gray-100 rounded-lg text-6xl">
            <svg class="" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                fill="currentColor" viewBox="0 0 24 24">
                <path fill-rule="evenodd"
                    d="M2 6a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6Zm4.996 2a1 1 0 0 0 0 2h.01a1 1 0 1 0 0-2h-.01ZM11 8a1 1 0 1 0 0 2h6a1 1 0 1 0 0-2h-6Zm-4.004 3a1 1 0 1 0 0 2h.01a1 1 0 1 0 0-2h-.01ZM11 11a1 1 0 1 0 0 2h6a1 1 0 1 0 0-2h-6Zm-4.004 3a1 1 0 1 0 0 2h.01a1 1 0 1 0 0-2h-.01ZM11 14a1 1 0 1 0 0 2h6a1 1 0 1 0 0-2h-6Z"
                    clip-rule="evenodd" />
            </svg>

        </button>
    </div>


    <!-- Vue Grille -->
    <div id="gridView">
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4">
            @if (empty($documents))
                <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                    role="alert">
                    <span class="font-medium">Aucune produit disponible.</span> Change a few things up and try
                    submitting again.
                </div>
            @else
                @foreach ($documents as $document)
                    <div class=" p-1 flex flex-wrap items-center justify-center">


                        <div
                            class="flex flex-col justify-center items-center text-gray-700 bg-white shadow-md bg-clip-border rounded-xl w-full lg:w-96">


                            <div class="book-card">
                                <div class="book-card__book">
                                    <div class="book-card__book-front">
                                        <img src="{{ asset('storage/' . $document->path) }}" alt="{{ $document->title }}"
                                            class="object-cover w-full h-full" />
                                    </div>
                                    <div class="book-card__book-back"></div>
                                    <div class="book-card__book-side"></div>
                                </div>
                            </div>

                            <div class="p-6">
                                <div class="flex items-center justify-between mb-2">
                                    <p
                                        class="block font-sans text-base antialiased font-medium leading-relaxed text-blue-gray-900">
                                        {{ $document->title }}
                                    </p>

                                </div>
                                <p
                                    class="block font-sans text-sm antialiased font-normal leading-normal text-gray-700 opacity-75">
                                    With plenty of talk and listen time, voice-activated Siri access, and an
                                    available wireless charging case.
                                </p>
                            </div>
                            <div class="p-6 pt-0">
                                <a href="{{ route('documents.show', $document->_id) }}"
                                    class="align-middle select-none font-sans font-bold text-center uppercase transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none text-xs py-3 px-6 rounded-lg shadow-gray-900/10 hover:shadow-gray-900/20 focus:opacity-[0.85] active:opacity-[0.85] active:shadow-none block w-full bg-blue-gray-900/10 text-blue-gray-900 shadow-none hover:scale-105 hover:shadow-none focus:scale-105 focus:shadow-none active:scale-100"
                                    type="button">
                                    Add to Cart
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="mt-4">
                    {{ $documents->links() }}
                </div>
            @endif



            <!-- Pagination -->

        </div>

    </div>



    <div id="listView" class="hidden">
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
                            {{ $item->created_at }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $item->updated_at }}
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
                        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200"
                            aria-labelledby="dropdownMenuIconButton">
                            <li>
                                <a href="{{ route('documents.show', $item->_id) }}"
                                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Detail
                                    Result</a>
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
    </div>



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

        <script>
            document.addEventListener("DOMContentLoaded", () => {
                const gridViewBtn = document.getElementById("gridViewBtn");
                const listViewBtn = document.getElementById("listViewBtn");
                const gridView = document.getElementById("gridView");
                const listView = document.getElementById("listView");

                gridViewBtn.addEventListener("click", () => {
                    gridView.classList.remove("hidden");
                    listView.classList.add("hidden");
                });

                listViewBtn.addEventListener("click", () => {
                    listView.classList.remove("hidden");
                    gridView.classList.add("hidden");
                });
            });


            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Succès',
                    text: '{{ session('success') }}',
                    toast: true,
                    position: 'top-end',
                    timer: 3000,
                    showConfirmButton: false,
                    timerProgressBar: true,
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Erreur',
                    text: '{{ session('error') }}',
                    toast: true,
                    position: 'top-end',
                    timer: 3000,
                    showConfirmButton: false,
                    timerProgressBar: true,
                });
            @endif
        </script>
    @endsection

</x-app-layout>
