<x-app-layout>

    @if (isset($error))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">Erreur :</strong>
            <span class="block sm:inline">{{ $error }}</span>
        </div>
    @endif


    <div class="relative overflow-x-auto">
        <table class="w-full text-sm text-left rtl:text-right text-gray-200" id="table">
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
                @foreach ($documents as $item)
                    <tr class="bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-900 dark:text-gray-200 text-gray-800">
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
                            <a class="sm:text-end  text-neutral-800 dark:text-neutral-200" href="{{ asset('storage/' . $item->path) }}"
                                target="_blank">View</a>


                            <a class="sm:text-end text-neutral-200"
                                href="{{ route('documents.detect-plagiarism', $item->id) }}" target="_blank">Checker</a>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>

    @section('script')
        <script>
            $(document).ready(function() {
                $('#table').DataTable({
                    "scrollX": true,
                    "fixedColumns": {
                        "start": 3
                    }
                });

                $('#candidatpresence').css('width', '100%');
            });
        </script>
    @endsection

</x-app-layout>
