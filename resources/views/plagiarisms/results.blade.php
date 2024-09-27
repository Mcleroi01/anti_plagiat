<x-app-layout>
    <h1>Résultats de la détection de plagiat pour {{ $document->filename }}</h1>

    <table>
        <thead>
            <tr>
                <th>Segment</th>
                <th>Pourcentage de similarité</th>
                <th>Source trouvée</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($results as $result)
                <tr>
                    <td>{{ $result->segment }}</td>
                    <td>{{ $result->similarity }}%</td>
                    <td><a href="{{ $result->url }}" target="_blank">Voir la source</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>

</x-app-layout>
