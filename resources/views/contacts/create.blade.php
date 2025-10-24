<!doctype html>
<html lang="{!! app()->getLocale() !!}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Jiri · Créez un contact</title>
</head>
<body>
    <h1>{!! __('headings.create_a_contact') !!}</h1>
    <form enctype="multipart/form-data" action="{{ route('contacts.store') }}" method="post">
        @csrf
        <fieldset class="fields contacts">
            <legend>Informations sur le contact</legend>
            <div class="field">
                <label for="name">Nom du contact<strong> *</strong></label>
                @error('name')
                <p class="error">{{ $message }}</p>
                @enderror
                <input type="text" name="name" id="name" value="{!! old('name') !!}" autocomplete="off">
            </div>
            <div class="field">
                <label for="email">Adresse mail du contact<strong> *</strong></label>
                @error('email')
                <p class="error">{{ $message }}</p>
                @enderror
                <input type="text" name="email" id="email" value="{!! old('email') !!}" autocomplete="off">
            </div>
            <div class="field">
                <input type="hidden" name="MAX_FILE_SIZE" value="300000"/>
                <label for="avatar">Avatar<strong> *</strong></label>
                @error('avatar')
                <p class="error">{{ $message }}</p>
                @enderror
                <input type="file" name="avatar" id="avatar">
            </div>
        </fieldset>
        <fieldset class="grid col-span-3 col-start-1 gap-3">
            <legend>
                Jiris disponibles
            </legend>
            @foreach($jiris as $jiri)
                <div class="field">
                    <label for="jiri{!! $jiri->id !!}">{!! $jiri->name !!}</label>
                    <input class="jiri"
                        type="checkbox"
                           name="jiris[{!! $jiri->id !!}]"
                           value="{!! $jiri->id !!}"
                           id="jiri{!! $jiri->id !!}">

                    <label for="role{!! $jiri->id !!}">Role<strong> *</strong></label>
                    <select name="jiris[{!! $jiri->id !!}][role]" id="role{!! $jiri->id !!}">
                        @foreach(\App\Enums\ContactRoles::cases() as $role)
                            <option value="{!! $role->value !!}">{!! __('labels-buttons.'.$role->value) !!}</option>
                        @endforeach
                    </select>
                </div>
            @endforeach
        </fieldset>
        <input type="submit" value="Créez le contact">
    </form>
</body>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const checkboxes = document.querySelectorAll('.jiri');

        checkboxes.forEach(checkbox => {
            const id = checkbox.value;
            const select = document.getElementById(`role${id}`);

            checkbox.checked ? select.disabled = false : select.disabled = true;

            checkbox.addEventListener('change', () => {
                checkbox.checked ? select.disabled = false : select.disabled = true;
            });
        });
    });
</script>
</html>
