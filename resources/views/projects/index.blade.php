<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Liste des projets</title>
</head>
<body>
    @if($projects->isNotEmpty())
        <h1>Projets disponibles</h1>
        <ul>
            @foreach($projects as $project)
                <li>{!! $project->name !!}</li>
            @endforeach
        </ul>
    @else
        <h1>Il n’y a pas de projet disponible</h1>
    @endif
</body>
</html>
