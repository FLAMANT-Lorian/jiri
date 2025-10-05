<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Liste des jiris</title>
</head>
<body>
    @if($jiris->isNotEmpty())
        <h1>Jiris disponible</h1>
        <ul>
            @foreach($jiris as $jiri)
                <li><a href="/jiris/{!! $jiri->id !!}">{!! $jiri->name !!}</a></li>
            @endforeach
        </ul>
    @else
        <h1>Il n’y a pas de jiri disponible</h1>
    @endif
</body>
</html>
