<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attestation d'Analyse</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }
        header {
            text-align: center;
            margin-bottom: 20px;
        }
        h1, h2 {
            margin: 0;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        footer {
            text-align: center;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <header>
        <h1>Attestation d'Analyse de Plagiat</h1>
        <p>Date : {{ now()->format('d/m/Y') }}</p>
    </header>

    <section>
        <h2>Détails de l'Analyse</h2>
        <p><strong>Nom du Document :</strong> {{ $document->filename }}</p>
        <p><strong>Pourcentage de Similitude :</strong> {{ $analysis['similarity_percentage'] }}%</p>
    </section>

    <section>
        <h2>Segments et Sources</h2>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Segment</th>
                    <th>Source</th>
                    <th>Similitude</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($analysis['segments'] as $index => $segment)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $segment['segment'] }}</td>
                    <td><a href="{{ $segment['source_link'] }}">{{ $segment['source_link'] }}</a></td>
                    <td>{{ $segment['similarity'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </section>

    <footer>
        <p>Ce rapport a été généré automatiquement par notre système de détection de plagiat.</p>
    </footer>
</body>
</html>
