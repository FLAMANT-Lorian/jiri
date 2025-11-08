@php
    use Carbon\Carbon;

    $labels = [
        ['name' => 'Nom', 'arrow_filter' => true, 'route' => route('jiris.index',['column' => 'name', 'order' => $order === 'asc' ? 'desc' : 'asc']), 'sort' => 'name'],
        ['name' => 'Date', 'arrow_filter' => true, 'route' => route('jiris.index',['column' => 'date', 'order' => $order === 'asc' ? 'desc' : 'asc']), 'sort' => 'date'],
        ['name' => 'Projets'],
        ['name' => 'Évalués'],
        ['name' => 'Évaluateurs'],
        ['name' => 'Actions'],
];

@endphp

<x-layouts.app>
    <x-slot:title>
        Vos jiris · Jiri
    </x-slot:title>

    <main class="grow">
        @if($jiris->isNotEmpty())
            <section class="flex flex-col gap-6 py-6 px-8">
                <div class="flex justify-between">
                    <h2 class="text-4xl font-semibold self-center">
                        Vos Jiris
                    </h2>
                    <div class="flex gap-6">
                        <div class="self-center relative">
                            <label class="pb-1  pr-2" for="search">Rechercher un jiri<small class="text-blue-600"> *</small></label>
                            <input class="p-2 border-1 border-gray-300 rounded-lg" type="search" name="search" id="search">
                        </div>
                        <a class="self-end font-medium block px-6 py-2.5 rounded-xl bg-blue-100 border border-blue-200 hover:bg-blue-200 hover:border-blue-300 transition-all"
                           href="{{ route('jiris.create') }}">Créer un nouveau jiri
                        </a>
                    </div>
                </div>
                <x-table.table :labels="$labels" :all_selector="true" table_title="Jiris" :order="$order" :sort="$sort">
                    @foreach($jiris as $jiri)
                        <tr>
                            <th class="px-2">
                                <input class="row_checkbox hover:cursor-pointer" type="checkbox"
                                       value="{!! $jiri->id !!}"
                                       name="col_selector" id="row{!! $jiri->id !!}" title="Sélectionner le Jiri">
                                <label for="row{!! $jiri->id !!}" class="sr-only">Séléctionner le Jiri</label>
                            </th>
                            <td class="text-gray-900 py-4">
                                <a href="{!! route('jiris.show', $jiri->id) !!}"
                                   class="hover:text-blue-700 transition-all">
                                    {!! $jiri->name !!}
                                </a>
                            </td>
                            <td class="text-gray-900 py-4">
                                @if(app()->getLocale() === 'fr')
                                    {{ Carbon::parse($jiri->date)->locale(app()->getLocale())->translatedFormat('j F Y') }}
                                @endif
                            </td>
                            <td>
                                {!! $jiri->projects->count() !!}
                            </td>
                            <td>
                                {!! $jiri->evaluated->count() !!}
                            </td>
                            <td>
                                {!! $jiri->evaluators->count() !!}
                            </td>
                            <td class="py-3">
                                <svg class="inline hover:cursor-pointer"
                                     width="49" height="27" viewBox="0 0 49 27" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="17.5" cy="13.5" r="1.5" fill="#101828"/>
                                    <circle cx="24.5" cy="13.5" r="1.5" fill="#101828"/>
                                    <circle cx="31.5" cy="13.5" r="1.5" fill="#101828"/>
                                </svg>
                            </td>
                        </tr>
                    @endforeach
                </x-table.table>

                {{ $jiris->links() }}
            </section>
        @else
            <p>Il n’y a pas de jiri disponible</p>
        @endif
    </main>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const checkbox_all = document.getElementById('all_col');
            const checkboxes = document.querySelectorAll('.row_checkbox');

            checkbox_all.addEventListener('change', e => {
                checkboxes.forEach(checkbox => {
                    if (e.currentTarget.checked) {
                        checkbox.checked = true;
                        checkbox.title = 'Désélectionner tous les Jiris';
                    } else {
                        checkbox.checked = false;
                        checkbox.title = 'Sélectionner tous les Jiris';
                    }
                });
            });
        });
    </script>

</x-layouts.app>
