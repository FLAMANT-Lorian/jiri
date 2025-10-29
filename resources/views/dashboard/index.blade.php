@php
    use Carbon\Carbon;

    $jiris_labels = [
           ['name' => 'Nom', 'arrow_filter' => false],
           ['name' => 'Date', 'arrow_filter' => false],
   ];

    $contacts_labels = [
           ['name' => 'Nom', 'arrow_filter' => false],
           ['name' => 'Email', 'arrow_filter' => false],
   ];


@endphp
<x-layouts.app>
    <x-slot:title>
        Tableau de bord · Jiri
    </x-slot:title>

    <main class="grow">
        @if($jiris->isNotEmpty())
            <section class="grid grid-cols-6 p-6">
                <div class="col-span-6 flex flex-col gap-4">
                    <h2 class="text-4xl font-semibold">Actions rapides</h2>
                    <div class="flex gap-4">
                        <a class="self-start font-medium block px-6 py-2.5 rounded-xl bg-blue-100 border border-blue-200 hover:bg-blue-200 hover:border-blue-300 transition-all"
                           href="{{ route('jiris.create') }}">Créer un nouveau jiri
                        </a>
                        <a class="self-start font-medium block px-6 py-2.5 rounded-xl bg-blue-100 border border-blue-200 hover:bg-blue-200 hover:border-blue-300 transition-all"
                           href="{{ route('contacts.create') }}">Créer un nouveau contact
                        </a>
                        <a class="self-start font-medium block px-6 py-2.5 rounded-xl bg-blue-100 border border-blue-200 hover:bg-blue-200 hover:border-blue-300 transition-all"
                           href="{{ route('projects.create') }}">Créer un nouveau projet
                        </a>
                    </div>
                </div>
            </section>
            <section class="flex gap-6 p-6">
                <article class="flex flex-col gap-6 w-[50%]">
                    <div class="flex justify-between">
                        <h2 class="text-3xl font-semibold self-center">
                            Vos derniers jiris
                        </h2>
                    </div>
                    <x-table.table :labels="$jiris_labels" :all_selector="false" table_title="jiris">
                        @foreach($jiris as $jiri)
                            <tr>
                                <td class="text-gray-900 py-4 px-4">
                                    <a href="{!! route('jiris.show', $jiri->id) !!}"
                                       class="hover:text-blue-700 transition-all">
                                        {!! $jiri->name !!}
                                    </a>
                                </td>
                                <td class="text-gray-900 py-4 px-4">
                                    @if(app()->getLocale() === 'fr')
                                        {{ Carbon::parse($jiri->date)->locale(app()->getLocale())->translatedFormat('j F Y') }}
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </x-table.table>
                </article>
                @else
                    <p>Il n’y a pas de jiri disponible</p>
                @endif

                @if($contacts->isNotEmpty())
                    <article class="flex flex-col gap-6 w-[50%]">
                        <div class="flex justify-between">
                            <h2 class="text-3xl font-semibold self-center">
                                Vos derniers contacts
                            </h2>
                        </div>
                        <x-table.table :labels="$contacts_labels" :all_selector="false" table_title="contacts">
                            @foreach($contacts as $contact)
                                <tr>
                                    <td class="text-gray-900 py-4 px-4">
                                        <a href="{!! route('jiris.show', $contact->id) !!}"
                                           class="hover:text-blue-700 transition-all">
                                            {!! $contact->name !!}
                                        </a>
                                    </td>
                                    <td class="text-gray-900 py-4 px-4">
                                        {!! $contact->email !!}
                                    </td>
                                </tr>
                            @endforeach
                        </x-table.table>
                    </article>
                @else
                    <p>Il n’y a pas de contacts disponible</p>
                @endif
            </section>
    </main>
</x-layouts.app>
