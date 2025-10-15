<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Liste des jiris</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="max-w-[60vh] mx-auto">
    <h1 class="text-4xl text-center">
        Récapitulatif pour {!! $contact->name !!}
    </h1>
    <a href="#" class="text-blue-500 hover:text-blue-700">Modifier le contact</a>
    <dl class="flex gap-6 flex-col">
        <div>
            <dt class="text-2xl font-bold pb-1">
                Nom du contact
            </dt>
            <dd>
                {!! $contact->name !!}
            </dd>
        </div>
        <div>
            <dt class="text-2xl font-bold pb-1">
                Adresse e-mail du contact
            </dt>
            <dd>
                {!! $contact->email !!}
            </dd>
        </div>
        @if(isset($contact['avatar']))
            <div>
                <dt class="text-2xl font-bold pb-1">
                    Avatar du contact
                </dt>
                <dd class="max-w-xs">
                    <img src="{!! asset('storage/'.$contact->avatar) !!}"
                         alt="Avatar de {!! $contact->name !!}">
                </dd>
            </div>
        @endif
    </dl>
</body>
</html>
