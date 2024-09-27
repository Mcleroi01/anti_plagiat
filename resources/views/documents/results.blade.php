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


</x-app-layout>
