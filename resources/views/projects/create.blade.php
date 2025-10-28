<x-layouts.app>
    <x-slot:title>
        Créez un projet · Jiri
    </x-slot:title>
    <main class="grow">
        <section class="flex flex-col px-8 py-6 gap-6">
            <h2 class="text-4xl font-semibold">
                Créez un projet
            </h2>
            <form action="{!! route('projects.store') !!}" method="post"
                  class="grid grid-cols-6 gap-6 bg-white p-6 rounded-2xl border border-gray-300">
                @csrf
                <small class="col-span-6">Les champs renseignés avec <span class="text-red-500">*</span> sont
                    obligatoires</small>
                <fieldset class="grid grid-cols-6 col-span-6 gap-6">
                    <legend class="font-semibold pb-2 text-2xl before:content-['⊙'] before:text-orange-600 before:pr-1">
                        Informations sur le projet
                    </legend>
                    <x-forms.input-text type="text" name="name" :required="true" placeholder="Portfolio">
                        Nom du projet
                    </x-forms.input-text>
                </fieldset>
                <fieldset class="grid col-span-3 col-start-1 gap-3">
                    <legend class="font-semibold pb-2 text-2xl before:content-['⊙'] before:text-orange-600 before:pr-1">
                        Jiris disponibles
                    </legend>
                    @foreach($jiris as $jiri)
                        <x-forms.input-checkbox name="jiris[{!! $jiri->id !!}]" :value="$jiri->id" id="jiri{!! $jiri->id !!}">
                            {!! $jiri->name !!}
                        </x-forms.input-checkbox>
                    @endforeach
                </fieldset>
                <x-forms.button class="col-span-6 font-medium block px-6 py-2.5 rounded-xl bg-blue-100 border border-blue-200 hover:bg-blue-200 hover:border-blue-300 transition-all">
                    Créez le projet
                </x-forms.button>
            </form>
        </section>
    </main>
</x-layouts.app>
