@php
    use Carbon\Carbon;
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
                    <a class="self-end font-medium block px-6 py-2.5 rounded-xl bg-blue-100 border border-blue-200 hover:bg-blue-200 hover:border-blue-300 transition-all"
                       href="{{ route('jiris.create') }}">Créer un nouveau jiri
                    </a>
                </div>
                <table
                    class="w-full overflow-hidden border-separate rounded-2xl bg-white border border-gray-300 border-spacing-0">
                    <thead>
                        <tr class="bg-gray-100 p-0">
                            <th class="px-4 py-2 w-[5%]">
                                <input class="all_col hover:cursor-pointer" type="checkbox" name="all_col_selector"
                                       id="all_col"
                                       title="Séléctionner tout les Jiris">
                                <label for="all_col" class="sr-only">Séléctionner tout les Jiris</label>
                            </th>
                            <th scope="col"
                                class="hover:cursor-pointer font-semibold text-gray-900 py-2 text-left min-w-[40%]">
                                <div class="flex items-center gap-2">
                                    Nom
                                    <svg width="10" height="17" viewBox="0 0 10 17" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M9.80111 9.48089C10.0663 9.84474 10.0663 10.4345 9.80111 10.7984L5.48011 16.7271C5.21492 17.091 4.78507 17.091 4.51989 16.7271L0.19889 10.7984C-0.0662961 10.4345 -0.0662961 9.84474 0.19889 9.48089C0.464077 9.11703 0.893926 9.11703 1.15911 9.48089L4.32095 13.8192L4.32095 -5.93649e-08L5.67905 0L5.67905 13.8192L8.84089 9.48089C9.10607 9.11703 9.53592 9.11703 9.80111 9.48089Z"
                                            fill="black"/>
                                    </svg>
                                </div>
                            </th>
                            <th scope="col"
                                class="hover:cursor-pointer font-semibold text-gray-900 py-2 text-left min-w-[40%]">
                                <div class="flex items-center gap-2">
                                    Date
                                    <svg width="10" height="17" viewBox="0 0 10 17" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M9.80111 9.48089C10.0663 9.84474 10.0663 10.4345 9.80111 10.7984L5.48011 16.7271C5.21492 17.091 4.78507 17.091 4.51989 16.7271L0.19889 10.7984C-0.0662961 10.4345 -0.0662961 9.84474 0.19889 9.48089C0.464077 9.11703 0.893926 9.11703 1.15911 9.48089L4.32095 13.8192L4.32095 -5.93649e-08L5.67905 0L5.67905 13.8192L8.84089 9.48089C9.10607 9.11703 9.53592 9.11703 9.80111 9.48089Z"
                                            fill="black"/>
                                    </svg>
                                </div>
                            </th>
                            <th class="text-left">
                                Projets
                            </th>
                            <th class="text-left">
                                Évalués
                            </th>
                            <th class="text-left">
                                Évaluateurs
                            </th>
                            <th scope="col" class="font-semibold text-gray-900 py-2 text-left w-[15%]">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
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
                    </tbody>
                </table>
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
