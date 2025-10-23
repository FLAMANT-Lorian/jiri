<x-layouts.app>
    <x-slot:title>
        {!! $contact->name !!} · Jiris
    </x-slot:title>
    <main class="grow">
        <section class="flex flex-col px-8 py-6 gap-6">
            <h2 class="text-4xl font-semibold">Modifier le contact</h2>
            <form enctype="multipart/form-data" class="grid grid-cols-6 gap-6 bg-white p-6 rounded-2xl border border-gray-300"
                  action="{{ route('contacts.update', $contact->id) }}" method="post">
                @method('PATCH')
                @csrf
                <small class="col-span-6">Les champs renseignés avec <span class="text-red-500">*</span> sont
                    obligatoires</small>
                <fieldset class="grid grid-cols-6 col-span-6 gap-6">
                    <legend class="font-semibold pb-2 text-2xl before:content-['⊙'] before:text-orange-600 before:pr-1">
                        Informations du contact
                    </legend>
                    <div class="flex flex-col gap-1 col-span-2">
                        <label class="font-semibold" for="name">Nom du contact<strong class="text-red-500">
                                *</strong></label>
                        @error('name')
                        <p class="absolute -bottom-6 error text-red-500">{{ $message }}</p>
                        @enderror
                        <input class="py-1 px-2 rounded-lg outline-1 outline-gray-300 focus:outline-orange-600"
                               type="text" name="name" id="name" value="{!! $contact->name !!}">
                    </div>
                    <div class="flex flex-col gap-1 row-start-2 col-span-2">
                        <label class="font-semibold" for="email">Adresse mail du contact<strong class="text-red-500">
                                *</strong></label>
                        @error('email')
                        <p class="absolute -bottom-6 error text-red-500">{{ $message }}</p>
                        @enderror
                        <input class="py-1 px-2 rounded-lg outline-1 outline-gray-300 focus:outline-orange-600"
                               type="text" name="email" id="email" value="{!! $contact->email !!}">
                    </div>
                    <div class="flex flex-col gap-1 col-start-4 col-span-2 row-span-2">
                        <input type="hidden" name="MAX_FILE_SIZE" value="300000"/>
                        <label class="font-semibold" for="avatar">Choisir un nouvel avatar</label>
                        @error('avatar')
                        <p class="absolute -bottom-6 error text-red-500">{{ $message }}</p>
                        @enderror
                        <input class="py-1 px-2 rounded-lg outline-1 outline-gray-300 focus:outline-orange-600"
                               type="file" name="avatar" id="avatar">
                    </div>
                    <div class="flex flex-col gap-1 col-start-6 col-span-1 row-span-2">
                        <p class="font-medium">Avatar actuel</p>
                        <img class="aspect-square object-cover rounded-3xl"
                             src="{!! asset('storage/contacts/original/' . $contact->avatar) !!}"
                             alt="Avatar de {!! $contact->name !!}">
                    </div>
                </fieldset>
                <fieldset class="grid col-span-4 row-start-3 gap-3">
                    <legend class="font-semibold pb-2 text-2xl before:content-['⊙'] before:text-orange-600 before:pr-1">
                        Jiris disponibles
                    </legend>
                    @foreach($jiris as $jiri)
                        <div class="flex flex-row gap-3 col-start-1 row-start-{!! $jiri->id !!}">
                            <div class="sub_field self-center">
                                <input
                                    @if($attendance = \App\Models\Attendance::where('jiri_id', $jiri->id)->where('contact_id', $contact->id)->first())
                                        checked
                                    @endif

                                    class="mr-1 jiri" type="checkbox" name="jiris[{!! $jiri->id !!}]"
                                    id="jiris{!! $jiri->id !!}"
                                    value="{!! $jiri->id !!}">
                                <label for="jiris{!! $jiri->id !!}" class="mr-2">{!! $jiri->name !!}</label>
                            </div>
                            <div class="sub_field">
                                <select class="border py-0.5 px-1 rounded-lg disabled:text-gray-300"
                                        name="jiris[{!! $jiri->id !!}][role]" id="role{!! $jiri->id !!}">
                                    @foreach(\App\Enums\ContactRoles::cases() as $role)
                                        <option
                                            @if($attendance && $attendance->role === $role->value)
                                                selected
                                            @endif
                                            value="{!! $role->value !!}">{!! __('labels-buttons.'.$role->value) !!}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endforeach
                </fieldset>
                <input
                    class="col-span-6 font-medium block px-6 py-2.5 rounded-xl bg-blue-100 border border-blue-200 hover:bg-blue-200 hover:border-blue-300 transition-all"
                    type="submit" value="Modifier le contact">
            </form>
        </section>
    </main>
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
</x-layouts.app>
