<!doctype html>
<html lang="{!! app()->getLocale() !!}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Jiri · Créez un contact</title>
</head>
<body>
    <h1>{!! __('headings.create_a_contact') !!}</h1>
    <form action="{{ route('contacts.store') }}" method="post">
        @csrf
        <fieldset class="fields contacts">
            <legend>Informations sur le contact</legend>
            <div class="field">
                <label for="name">Nom du contact<strong> *</strong></label>
                <input type="text" name="name" id="name">
            </div>
            <div class="field">
                <label for="email">Adresse mail du contact<strong> *</strong></label>
                <input type="text" name="email" id="email">
            </div>
        </fieldset>
        <fieldset class="fields jiris">
            <legend>Jiris disponibles</legend>
            @foreach($jiris as $jiri)
                <div class="field">
                    <label for="jiri{!! $jiri->id !!}">{!! $jiri->name !!}</label>
                    <input type="checkbox"
                           name="jiris[{!! $jiri->id !!}]"
                           value="{!! $jiri->id !!}"
                           id="jiri{!! $jiri->id !!}">

                    {{--TODO : Faire un meilleur syntaxe HTML--}}
                    <label for="role">Role<strong> *</strong></label>
                    <select name="jiris[{!! $jiri->id !!}][role]" id="role">
                        @foreach(\App\Enums\ContactRoles::cases() as $role)
                            <option value="{!! $role->value !!}">{!! __('labels-buttons.'.$role->value) !!}</option>
                        @endforeach
                    </select>

                    <div class="sub_fields" style="margin-left: 24px">
                        @foreach($jiri->projects as $project)
                            <div class="sub_field">
                                <label for="projects{!! $project->id !!}">{!! $project->name !!}</label>
                                <input type="checkbox" name="jiris[{!! $jiri->id !!}][homeworks][]"
                                       value="{!! $project->id !!}" id="projects{!! $project->id !!}">
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </fieldset>
        <input type="submit" value="Créez le contact">
    </form>
</body>
</html>
