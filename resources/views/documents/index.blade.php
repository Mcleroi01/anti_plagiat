<x-app-layout>

    @if (isset($error))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">Erreur :</strong>
            <span class="block sm:inline">{{ $error }}</span>
        </div>
    @endif
    <a href="{{ route('documents.upload') }}"
        class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700">Dark</a>

    <div class="relative overflow-x-auto">
        <table class="w-full text-sm text-left rtl:text-right text-gray-200">
            <thead class="text-xs text-gray-300 uppercase bg-gradient-to-br from-gray-800 to-gray-900 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Name
                    </th>
                    <th scope="col" class="px-6 py-3">
                       Fichier
                    </th>

                    <th scope="col" class="px-6 py-3">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($documents as $item)
                    <tr class="bg-gradient-to-br from-gray-800 to-gray-900 border-b  dark:border-gray-700">
                        <th scope="row"
                            class="px-6 py-4 font-medium  whitespace-nowrap text-white">
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
                            <a class="sm:text-end  text-neutral-200"
                                href="{{ asset('storage/' . $item->path) }}" target="_blank">View</a>


                            <a class="sm:text-end text-neutral-200"
                                href="{{ route('documents.detect-plagiarism', $item->id) }}" target="_blank">Checker</a>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>

</x-app-layout>
