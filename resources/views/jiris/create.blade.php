<x-layouts.app>
    <x-slot:title>
        Créer un jiri · Jiri
    </x-slot:title>
    <main class="grow">
        <section class="flex flex-col px-8 py-6 gap-6">
            <h2 class="text-4xl font-semibold">
                {!! __('headings.create_a_jiri') !!}
            </h2>
            <form action="{!! route('jiris.store') !!}" method="post"
                  class="grid grid-cols-6 gap-6 bg-white p-6 rounded-2xl border border-gray-300">
                @csrf
                <small class="col-span-6">Les champs renseignés avec <span class="text-red-500">*</span> sont
                    obligatoires</small>
                <fieldset class="grid grid-cols-6 col-span-6 gap-6">
                    <legend class="font-semibold pb-2 text-2xl before:content-['⊙'] before:text-orange-600 before:pr-1">
                        Informations sur le jiri
                    </legend>
                    <div class="relative flex flex-col gap-1 col-span-3">
                        <label for="name" class="font-semibold">{!! __('labels-buttons.jiri_name') !!}
                            <small class="text-red-500"> *</small>
                        </label>
                        <input type="text" placeholder="Jhon Doe"
                               class="py-1 px-2 rounded-lg outline-1 outline-gray-300 focus:outline-blue-500"
                               name="name" id="name" value="{!! old('name') !!}">
                        @error('name')
                        <p class="absolute -bottom-6 error text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="relative flex flex-col gap-1 col-span-3">
                        <label class="font-semibold" for="date">Date du jiri
                            <small class="text-red-500"> *</small></label>
                        <input type="date" placeholder="21/10/2005"
                               class="py-1 px-2 rounded-lg outline-1 outline-gray-300 focus:outline-blue-500"
                               name="date" id="date" value="{!! old('date') !!}">
                        @error('date')
                        <p class="absolute -bottom-6 error text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex flex-col gap-1 col-span-6 col-start-1">
                        <label class="font-semibold" for="name">Description</label>
                        @error('description')
                        <p class="error">{{ $message }}</p>
                        @enderror
                        <textarea placeholder="Jury de fin d’année ..."
                                  class="min-h-28 max-h-70 py-1 px-2 rounded-lg outline-1 outline-gray-300 focus:outline-blue-500"
                                  name="description"
                                  id="description"
                        >{!! old('description') !!}</textarea>
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
                                       value="{!! $contact->id !!}">
                                <label for="contacts{!! $contact->id !!}" class="mr-2">{!! $contact->name !!}</label>
                            </div>
                            <div class="sub_field">
                                <select class="border py-0.5 px-1 rounded-lg disabled:text-gray-300"
                                        name="contacts[{!! $contact->id !!}][role]" id="role{!! $contact->id !!}">
                                    @foreach(\App\Enums\ContactRoles::cases() as $role)
                                        <option
                                            value="{!! $role->value !!}">{!! __('labels-buttons.'.$role->value) !!}</option>
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
                            <div class="flex flex-row gap-3 col-start-1 row-start-{!! $project->id !!}">
                                <input class="mr-1" type="checkbox" name="projects[{!! $project->id !!}]"
                                       id="projects{!! $project->id !!}"
                                       value="{!! $project->id !!}">
                                <label class="mr-2" for="projects{!! $project->id !!}">{!! $project->name !!}</label>
                            </div>
                        @endforeach
                </fieldset>
                <input
                    class="col-span-6 font-medium block px-6 py-2.5 rounded-xl bg-blue-100 border border-blue-200 hover:bg-blue-200 hover:border-blue-300 transition-all"
                    type="submit" value="{!! __('labels-buttons.create_a_jiri') !!}">
            </form>
        </section>
    </main>
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
</x-layouts.app>
