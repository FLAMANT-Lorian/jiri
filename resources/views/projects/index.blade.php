@php
    use Carbon\Carbon;

       $labels = [
        ['name' => 'Nom', 'arrow_filter' => true],
        ['name' => 'Date', 'arrow_filter' => true],
        ['name' => 'Actions'],
];
@endphp

<x-layouts.app>
    <x-slot:title>
        Vos projets · Jiri
    </x-slot:title>

    <main class="grow">
        @if($projects->isNotEmpty())
            <section class="flex flex-col gap-6 py-6 px-8">
                <div class="flex justify-between items-center">
                    <h2 class="text-4xl font-semibold">
                        Vos projets
                    </h2>
                    <div class="flex gap-6">
                        <div class="self-center relative">
                            <label class="pb-1  pr-2" for="search">Rechercher un projet<small class="text-blue-600"> *</small></label>
                            <input class="p-2 border-1 border-gray-300 rounded-lg" type="text" name="search" id="search">
                            <img src="{!! asset('assets/img/search.svg') !!}" class="max-w-5 absolute top-3 right-4" alt="Oeil fermé">
                        </div>
                        <a class="self-end font-medium block px-6 py-2.5 rounded-xl bg-blue-100 border border-blue-200 hover:bg-blue-200 hover:border-blue-300 transition-all"
                           href="{{ route('projects.create') }}">Créer un nouveau projet
                        </a>
                    </div>
                </div>
                <table
                    class="w-full overflow-hidden border-separate rounded-2xl bg-white border border-gray-300 border-spacing-0">
                    <thead class="">
                        <tr class="bg-gray-100 p-0">
                            <th class="px-4 py-2 w-[5%]">
                                <input class="all_col hover:cursor-pointer" type="checkbox" name="all_col_selector"
                                       id="all_col"
                                       title="Séléctionner tout les projets">
                                <label for="all_col" class="sr-only">Séléctionner tout les projets</label>
                            </th>
                            <th scope="col" class="font-semibold text-gray-900 py-2 text-left min-w-[40%]">
                                Nom
                            </th>
                            <th scope="col" class="font-semibold text-gray-900 py-2 text-left w-[15%]">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($projects as $project)
                            <tr>
                                <th class="px-2">
                                    <input class="row_checkbox hover:cursor-pointer" type="checkbox"
                                           value="{!! $project->id !!}"
                                           name="col_selector" id="row{!! $project->id !!}"
                                           title="Sélectionner le projets">
                                    <label for="row{!! $project->id !!}" class="sr-only">Séléctionner le projets</label>
                                </th>
                                <td class="text-gray-900 py-4">
                                    <a href="{!! route('projects.show', $project->id) !!}"
                                       class="hover:text-blue-700 transition-all">
                                        {!! $project->name !!}
                                    </a>
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
                    </tbody>
                </table>
                {!! $projects->links() !!}
            </section>
        @else
            <p>Il n’y a pas de projet disponible</p>
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
                        checkbox.title = 'Désélectionner tous les projets';
                    } else {
                        checkbox.checked = false;
                        checkbox.title = 'Sélectionner tous les projets';
                    }
                });
            });
        });
    </script>
</x-layouts.app>
