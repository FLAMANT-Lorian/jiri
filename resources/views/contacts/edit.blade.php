<!doctype html>
<html lang="{!! app()->getLocale() !!}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Jiri · Modifier le contact</title>
</head>
<body>
    <h1>Modifier les informations du contact</h1>

    <form action="{{ route('contacts.update', $contact->id) }}" method="post">
        @method('PATCH')
        @csrf
        <fieldset>
            <legend>Informations du contact</legend>
            <div class="field">
                <label for="name">Nom du contact<strong> *</strong></label>
                @error('name')
                <p class="error">{{ $message }}</p>
                @enderror
                <input type="text" name="name" id="name" value="{!! $contact->name !!}">
            </div>
            <div class="field">
                <label for="email">Adresse mail du contact<strong> *</strong></label>
                @error('email')
                <p class="error">{{ $message }}</p>
                @enderror
                <input type="text" name="email" id="email" value="{!! $contact->email !!}">
            </div>
            <div class="field">
                <input type="hidden" name="MAX_FILE_SIZE" value="300000" />
                <label for="avatar">Changer d’avatar<strong> *</strong></label>
                @error('avatar')
                <p class="error">{{ $message }}</p>
                @enderror
                <input type="file" name="avatar" id="avatar">
                <img
                    src="{!! asset('storage/contacts/200/' .substr_replace($contact->avatar, "_200x200", -4, 0)) !!}"
                    alt="Avatar de {!! $contact->name !!}">
            </div>
        </fieldset>
        <input type="submit" value="Modifier le contact">
    </form>
</body>
</html>
