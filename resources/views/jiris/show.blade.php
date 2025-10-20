@php
    use Carbon\Carbon;
@endphp

<x-layouts.app>
    <x-slot:title>
        {!! $jiri->name !!} · Jiris
    </x-slot:title>

    <main class="grow">
        <section class="px-8 py-6">
            <div class="flex justify-between mb-4">
                <h2 class="text-4xl font-semibold self-center">
                    Jiri : {!! $jiri->name !!}
                </h2>
                <a class="self-end font-medium block px-6 py-2.5 rounded-xl bg-emerald-100 border border-emerald-200 hover:bg-emerald-200 hover:border-emerald-300 transition-all"
                   href="{{ route('jiris.edit', $jiri->id) }}">Modifier le jiri</a>
            </div>
            <div class="informations grid grid-cols-6 gap-6 mb-8">
                <div class="name bg-white p-6 col-span-3 rounded-2xl border border-gray-300">
                    <h3 class="text-lg font-normal pb-2">Nom</h3>
                    <p class="text-3xl font-semibold">{!! $jiri->name !!}</p>
                </div>
                <div class="date bg-white p-6 col-span-3 rounded-2xl border border-gray-300">
                    <h3 class="text-lg font-normal pb-2">Date</h3>
                    <p class="text-3xl font-semibold">{!! Carbon::parse($jiri->date)->locale(app()->getLocale())->translatedFormat('j F Y') !!}</p>
                </div>
                <div class="bg-white p-6 col-span-2 row-start-2 rounded-2xl border border-gray-300">
                    <h3 class="text-lg font-normal pb-2 before:content-['⊙'] before:text-orange-700 before:pr-1">Nombre
                        de projets</h3>
                    <p class="text-3xl font-semibold">{!! $jiri->projects->count() !!}</p>
                </div>
                <div class="bg-white p-6 col-span-2 row-start-2 rounded-2xl border border-gray-300">
                    <h3 class="text-lg font-normal pb-2 before:content-['⊙'] before:text-orange-700 before:pr-1">Nombre
                        d’évaluateurs</h3>
                    <p class="text-3xl font-semibold">{!! $jiri->evaluators->count() !!}</p>
                </div>
                <div class="bg-white p-6 col-span-2 row-start-2 rounded-2xl border border-gray-300">
                    <h3 class="text-lg font-normal pb-2 before:content-['⊙'] before:text-orange-700 before:pr-1">Nombre
                        d’évalués</h3>
                    <p class="text-3xl font-semibold">{!! $jiri->evaluated->count() !!}</p>
                </div>
            </div>
            <article class="mb-8">
                <h3 class="text-3xl font-semibold mb-4">Contacts</h3>
                <table
                    class="w-full overflow-hidden border-separate rounded-2xl bg-white border border-gray-300 border-spacing-0">
                    <thead>
                        <tr class="bg-gray-100 p-0">
                            <th scope="col"
                                class="pl-6 hover:cursor-pointer font-semibold text-gray-900 py-2 text-left min-w-[40%]">
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
                                    Adresse e-mail
                                    <svg width="10" height="17" viewBox="0 0 10 17" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M9.80111 9.48089C10.0663 9.84474 10.0663 10.4345 9.80111 10.7984L5.48011 16.7271C5.21492 17.091 4.78507 17.091 4.51989 16.7271L0.19889 10.7984C-0.0662961 10.4345 -0.0662961 9.84474 0.19889 9.48089C0.464077 9.11703 0.893926 9.11703 1.15911 9.48089L4.32095 13.8192L4.32095 -5.93649e-08L5.67905 0L5.67905 13.8192L8.84089 9.48089C9.10607 9.11703 9.53592 9.11703 9.80111 9.48089Z"
                                            fill="black"/>
                                    </svg>
                                </div>
                            </th>
                            <th scope="col"
                                class="pr-6 hover:cursor-pointer font-semibold text-gray-900 py-2 text-left min-w-[40%]">
                                <div class="flex items-center gap-2">
                                    Rôle
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($jiri->contacts as $contact)
                            <tr>
                                <td class="pl-6 text-gray-900 py-4">
                                    {!! $contact->name !!}
                                </td>
                                <td class="py-4 text-gray-900">
                                    {!! $contact->email !!}
                                </td>
                                <td class="pr-6 py-4 text-gray-900">
                                    {!! __('labels-buttons.' . $jiri->attendances()->where('contact_id', '=', $contact->id)->pluck('role')->first()) !!}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </article>
            <article class="mb-8">
                <h3 class="text-3xl font-semibold mb-4">Projets</h3>
                <table
                    class="w-full overflow-hidden border-separate rounded-2xl bg-white border border-gray-300 border-spacing-0">
                    <thead>
                        <tr class="bg-gray-100 p-0">
                            <th scope="col"
                                class="pl-6 hover:cursor-pointer font-semibold text-gray-900 py-2 text-left w-[50%]">
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
                                class="hover:cursor-pointer font-semibold text-gray-900 py-2 text-left w-[50%]">
                                <div class="flex items-center gap-2">
                                    Nombre d'implémentations
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($jiri->projects as $project)
                            <tr>
                                <td class="pl-6 text-gray-900 py-4">
                                    {!! $project->name !!}
                                </td>
                                <td class="py-4 text-gray-900">
                                    {!! $jiri->evaluated()->count() !!}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </article>
            <a class="text-center self-end font-medium block px-6 py-2.5 rounded-xl bg-red-100 border border-red-200 hover:bg-red-200 hover:border-red-300 transition-all"
               href="#">Supprimer le jiri</a>
        </section>
    </main>
</x-layouts.app>
