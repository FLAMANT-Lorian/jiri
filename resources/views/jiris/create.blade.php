<!doctype html>
<html lang="{!! app()->getLocale(); !!}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Jiri · Créez un jiri</title>
    {{--    @vite(['resources/css/app.css', 'resources/js/app.js'])--}}
</head>
<body>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const checkboxes = document.querySelectorAll('.contact');

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
    <h1>{!! __('headings.create_a_jiri') !!}</h1>
    <form action="{!! route('jiris.store') !!}" method="post">
        @csrf
        <fieldset class="fields jiris">
            <legend>Informations sur le jiri</legend>
            <div class="field">
                <label for="name">{!! __('labels-buttons.jiri_name') !!}<small> *</small></label>
                @error('name')
                <p class="error">{{ $message }}</p>
                @enderror
                <input type="text" name="name" id="name" value="{!! old('name') !!}">
            </div>
            <div class="field">
                <label for="date">Date du jiri <small> *</small></label>
                @error('date')
                <p class="error">{{ $message }}</p>
                @enderror
                <input type="text" name="date" id="date" value="{!! old('date') !!}">
            </div>
            <div class="field">
                <label for="name">Description</label>
                @error('description')
                <p class="error">{{ $message }}</p>
                @enderror
                <input type="text" name="description" id="description" value="{!! old('description') !!}">
            </div>
        </fieldset>
        <fieldset class="fields contacts">
            <legend>Contacts disponibles</legend>
            @foreach($contacts as $contact)
                <div class="field" style="display: flex; flex-direction: row">
                    <div class="sub_field">
                        <input class="contact" type="checkbox" name="contacts[{!! $contact->id !!}]"
                               id="contacts{!! $contact->id !!}"
                               value="{!! $contact->id !!}">
                        <label for="contacts{!! $contact->id !!}"
                               style="margin-right: 10px">{!! $contact->name !!}</label>
                    </div>
                    <div class="sub_field">
                        <select name="contacts[{!! $contact->id !!}][role]" id="role{!! $contact->id !!}">
                            @foreach(\App\Enums\ContactRoles::cases() as $role)
                                <option value="{!! $role->value !!}">{!! __('labels-buttons.'.$role->value) !!}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            @endforeach
        </fieldset>
        <fieldset class="fields projects">
            <legend>Projets disponibles</legend>
            @foreach($projects as $project)
                <div class="field">
                    <input type="checkbox" name="projects[{!! $project->id !!}]" id="projects{!! $project->id !!}"
                           value="{!! $project->id !!}">
                    <label for="projects{!! $project->id !!}">{!! $project->name !!}</label>
                </div>
            @endforeach
        </fieldset>
        <input type="submit" value="{!! __('labels-buttons.create_a_jiri') !!}">
    </form>
</body>
</html>
