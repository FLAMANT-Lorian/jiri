<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Modifier le jiri</title>
</head>
<body>
    <h1>Modifier le jiri</h1>
    <form action="{!! route('jiris.update', $jiri->id) !!}" method="post">
        @method('PATCH')
        @csrf
        <fieldset class="fields jiris">
            <legend>Informations sur le jiri</legend>
            <div class="field">
                <label for="name">{!! __('labels-buttons.jiri_name') !!}<small> *</small></label>
                @error('name')
                <p class="error">{{ $message }}</p>
                @enderror
                <input type="text" name="name" id="name" value="{!! $jiri->name !!}">
            </div>
            <div class="field">
                <label for="date">Date du jiri <small> *</small></label>
                @error('date')
                <p class="error">{{ $message }}</p>
                @enderror
                <input type="text" name="date" id="date" value="{!! $jiri->date !!}">
            </div>
            <div class="field">
                <label for="name">Description</label>
                @error('description')
                <p class="error">{{ $message }}</p>
                @enderror
                <input type="text" name="description" id="description" value="{!! $jiri->description !!}">
            </div>
        </fieldset>
        <fieldset class="fields contacts">
            <legend>Contacts disponibles</legend>
            @foreach($contacts as $contact)
                <div class="field" style="display: flex; flex-direction: row">
                    <div class="sub_field">
                        <input type="checkbox" name="contacts[{!! $contact->id !!}]" id="contacts"
                               value="{!! $contact->id !!}"
                               @if(\App\Models\Attendance::where('jiri_id', $jiri->id)->where('contact_id', $contact->id)->first())
                                   checked
                            @endif>
                        <label for="contacts" style="margin-right: 10px">{!! $contact->name !!}</label>
                    </div>
                    <div class="sub_field">
                        <select name="contacts[{!! $contact->id !!}][role]" id="role">
                            @foreach(\App\Enums\ContactRoles::cases() as $role)
                                @php
                                    $attendance = \App\Models\Attendance::where('jiri_id', $jiri->id)->where('contact_id', $contact->id)->first()
                                @endphp
                                <option value="{!! $role->value !!}"
                                        @if($attendance && $attendance->role === $role->value)
                                            selected
                                    @endif>
                                    {!! __('labels-buttons.'.$role->value) !!}
                                </option>
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
                    <input type="checkbox" name="projects[{!! $project->id !!}]" id="projects"
                           value="{!! $project->id !!}"
                           @if(\App\Models\Homework::where('jiri_id', $jiri->id)->where('project_id', $project->id)->first())
                               checked
                        @endif>
                    <label for="projects">{!! $project->name !!}</label>
                </div>
            @endforeach
        </fieldset>
        <input type="submit" value="{!! __('labels-buttons.update_a_jiri') !!}">
    </form>
</body>
</html>
