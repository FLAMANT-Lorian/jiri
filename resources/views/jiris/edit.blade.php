<x-layouts.app>
    <x-slot:title>
        Modifier le jiri · Jiri
    </x-slot:title>

    <main class="grow">
        <section class="flex flex-col px-8 py-6 gap-6">
            <h2 class="text-4xl font-semibold">Modifier le jiri</h2>
            <form class="grid grid-cols-6 gap-6 bg-white p-6 rounded-2xl border border-gray-300"
                  action="{!! route('jiris.update', $jiri->id) !!}" method="post">
                @method('PATCH')
                @csrf
                <small class="col-span-6">Les champs renseignés avec <span class="text-red-500">*</span> sont
                    obligatoires</small>
                <fieldset class="grid grid-cols-6 col-span-6 gap-6">
                    <legend class="font-semibold pb-2 text-2xl before:content-['⊙'] before:text-orange-600 before:pr-1">
                        Informations sur le jiri
                    </legend>
                    <div class="flex flex-col gap-1 col-span-3">
                        <label class="font-semibold" for="name">{!! __('labels-buttons.jiri_name') !!}<small
                                class="text-red-500"> *</small></label>
                        @error('name')
                        <p class="error">{{ $message }}</p>
                        @enderror
                        <input class="py-1 px-2 rounded-lg outline-1 outline-gray-300 focus:outline-orange-600"
                               type="text" name="name" id="name" value="{!! $jiri->name !!}">
                    </div>
                    <div class="flex flex-col gap-1 col-span-3">
                        <label class="font-semibold" for="date">Date du jiri <small class="text-red-500">
                                *</small></label>
                        @error('date')
                        <p class="error">{{ $message }}</p>
                        @enderror
                        <input class="py-1 px-2 rounded-lg outline-1 outline-gray-300 focus:outline-orange-600"
                               type="text" name="date" id="date" value="{!! $jiri->date !!}">
                    </div>
                    <div class="flex flex-col gap-1 col-span-6 col-start-1">
                        <label class="font-semibold" for="name">Description</label>
                        @error('description')
                        <p class="error">{{ $message }}</p>
                        @enderror
                        <textarea placeholder="Jury de fin d’année ..."
                                  class="min-h-28 max-h-70 py-1 px-2 rounded-lg outline-1 outline-gray-300 focus:outline-orange-600"
                                  name="description"
                                  id="description"
                        >{!! $jiri->description !!}</textarea>
                    </div>
                </fieldset>
                <fieldset class="grid col-span-3 col-start-1 gap-3">
                    <legend class="font-semibold pb-2 text-2xl before:content-['⊙'] before:text-orange-600 before:pr-1">
                        Contacts disponibles
                    </legend>
                    @foreach($contacts as $contact)
                        <div class="flex flex-row gap-3 col-start-1 row-start-{!! $contact->id !!}">
                            <div class="sub_field self-center">
                                <input class="mr-1 contact" type="checkbox" name="contacts[{!! $contact->id !!}]"
                                       id="contacts{!! $contact->id !!}"
                                       value="{!! $contact->id !!}"
                                       @if( $attendance = \App\Models\Attendance::where('jiri_id', $jiri->id)->where('contact_id', $contact->id)->first())
                                           checked
                                    @endif>
                                <label for="contacts{!! $contact->id !!}"
                                       style="margin-right: 10px">{!! $contact->name !!}</label>
                            </div>
                            <div class="sub_field">
                                <select class="border py-0.5 px-1 rounded-lg disabled:text-gray-300"
                                        name="contacts[{!! $contact->id !!}][role]" id="role{!! $contact->id !!}">
                                    @foreach(\App\Enums\ContactRoles::cases() as $role)
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
                <fieldset class="grid col-span-3 col-start-4 gap-3">
                    <legend class="font-semibold pb-2 text-2xl before:content-['⊙'] before:text-orange-600 before:pr-1">
                        Projets disponibles
                    </legend>
                    @foreach($projects as $project)
                        <div class="field">
                            <input class="mr-1" type="checkbox" name="projects[{!! $project->id !!}]"
                                   id="projects{!! $project->id !!}"
                                   value="{!! $project->id !!}"
                                   @if(\App\Models\Homework::where('jiri_id', $jiri->id)->where('project_id', $project->id)->first())
                                       checked
                                @endif>
                            <label class="mr-2" for="projects{!! $project->id !!}">{!! $project->name !!}</label>
                        </div>
                    @endforeach
                </fieldset>
                <input
                    class="col-span-6 font-medium block px-6 py-2.5 rounded-xl bg-blue-100 border border-blue-200 hover:bg-blue-200 hover:border-blue-300 transition-all"
                    type="submit" value="Modifier le Jiri">
            </form>
        </section>
    </main>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
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
</x-layouts.app>
