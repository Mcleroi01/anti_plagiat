<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: #333;
        }

        header {
            text-align: center;
            padding: 20px;
            background-color: #f4f4f4;
            border-bottom: 2px solid #ddd;
        }

        header em {
            font-style: italic;
            font-size: 1.2em;
        }

        header h1,
        header h2,
        header p {
            margin: 5px 0;
        }

        section {
            padding: 20px;
            margin: 20px auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            max-width: 800px;
        }

        h2 {
            margin-top: 0;
            color: #444;
        }

        p {
            margin: 10px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th,
        table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        table th {
            background-color: #f4f4f4;
            color: #333;
        }

        table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table tbody tr:nth-child(odd) {
            background-color: #fff;
        }

        footer {
            margin: 30px 0;
            font-size: 0.9em;
            color: #555;
            padding: 10px;
            font-weight: 200;
        }
    </style>
</head>

<body>
    <header>
        <em>République Démocratique du Congo</em>
        <p>MINISTERE DE L’ENSEIGNEMENT SUPÉRIEUR ET UNIVERSITAIRE</p>
        <h2>INSTITUT SUPERIEUR PEDAGOGIQUE DE LA GOMBE</h2>
        <p>B.P.3580-Kinshasa/Gombe</p>

    </header>

    <section>
        <h2>Détails de l'Analyse</h2>
        <p><strong>Nom du Document :</strong> {{ $document->filename }}</p>
        <p><strong>Pourcentage de Similitude Global :</strong> {{ $document->highlightedText->average_similarity }}%</p>
        <p>
            Après une analyse approfondie, nous avons déterminé que le pourcentage moyen de similitude pour le document
            soumis est de
            <strong>{{ $document->highlightedText->average_similarity ?? 'non calculé' }}%</strong>. Les détails des
            segments similaires sont fournis ci-dessous, classés par source et niveau de correspondance.
        </p>
    </section>

    @if ($localResults->isNotEmpty())
        <section>
            <h2>Segments et Sources Locales</h2>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Segment</th>
                        <th>Source</th>
                        <th>Page</th>
                        <th>Similitude</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($localResults as $index => $result)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ Str::limit($result->search_phrase, 50) }}</td>
                            <td>{{ Str::limit($result->best_match, 50) }}</td>
                            <td>{{ $result->page_number }}</td>
                            <td>{{ $result->similarity_percentage }}%</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </section>
    @endif

    @if ($apiResults->isNotEmpty())
        <section>
            <h2>Résultats API</h2>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Phrase</th>
                        <th>Source</th>
                        <th>Similitude</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($apiResults as $index => $result)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ Str::limit($result->search_phrase, 50) }}</td>
                            <td>{{ Str::limit($result->result_snippet) }}</td>
                            <td>{{ $result->similarity_percentage }}%</td>
                            <td>{{ $result->page_number }}</td>
                            <td class="px-6 py-4">
                                <a href="{{ $result->result_link }}" class="text-blue-500 hover:underline"
                                    target="_blank">
                                    {{ substr($result->result_link, 0, 30) }} ...
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </section>
    @endif

    <footer>
        <div style="text-align: right; margin-top: 20px;">
            Fait à Kinshasa le {{ now()->format('d/m/Y') }}
        </div>
        <p style="text-align: center;">Ce rapport a été généré automatiquement par notre système de détection de
            plagiat.</p>
    </footer>
</body>

</html>
