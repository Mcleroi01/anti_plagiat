<x-app-layout>
    <h1>Document : {{ $document->filename }}</h1>

    @if ($document->plagiarismResults->isEmpty())
        <p>Aucun plagiat détecté pour l'instant.</p>
    @else
        <ul>
            @foreach ($document->plagiarismResults as $result)
                <li>{{ $result->segment }} - Similarité : {{ $result->similarity }}% - <a href="{{ $result->url }}"
                        target="_blank">Source</a></li>
            @endforeach
        </ul>
    @endif
</x-app-layout>
