<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Liste des contacts</title>
</head>
<body>
    @if($contacts->isNotEmpty())
        <h1>Contacts disponibles</h1>
        <ul>
            @foreach($contacts as $contact)
                <li>
                    {!! $contact->name !!}
                </li>
            @endforeach
        </ul>
    @else
        <h1>Il n’y a pas de contact disponible</h1>
    @endif
</body>
</html>
