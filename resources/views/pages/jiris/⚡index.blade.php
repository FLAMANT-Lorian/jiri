<?php

use App\Models\Jiri;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Carbon\Carbon;

new class extends Component {

    public string $term = '';

    public array $labels = [
        ['name' => 'Nom', 'arrow_filter' => true, 'route' => '/'],
        ['name' => 'Date', 'arrow_filter' => true, 'route' => '/'],
        ['name' => 'Projets'],
        ['name' => 'Évalués'],
        ['name' => 'Évaluateurs'],
        ['name' => 'Actions'],
    ];

    #[Computed]
    public function jiris()
    {
        return auth()->user()
            ->jiris()
            ->where('name', 'like', '%' . $this->term . '%')
            ->orderBy('date', 'asc')
            ->with(['attendances', 'projects', 'user'])
            ->get();
    }

    public function delete(string $id): void
    {
        $this->dispatch('open_modal', ['form' => 'forms::jiri_delete', 'model_id' => $id]);
    }

    #[On('jiris_list_changed')]
    public function reset_jiris_list()
    {
        unset($this->jiris);
    }

};
?>


<main class="grow">
    <section class="flex flex-col gap-6 py-6 px-8">
        <div class="flex justify-between">
            <h2 class="text-4xl font-semibold self-center">
                Vos Jiris
            </h2>
            <div class="flex gap-6">
                <div class="self-center relative">
                    <label class="pb-1  pr-2" for="search">Rechercher un jiri<small class="text-blue-600">
                            *</small></label>
                    <input wire:model.live.debounce.250ms="term" class="p-2 border-1 border-gray-300 rounded-lg"
                           type="search" name="search" id="search">
                </div>
                <a class="self-end font-medium block px-6 py-2.5 rounded-xl bg-blue-100 border border-blue-200 hover:bg-blue-200 hover:border-blue-300 transition-all"
                   href="{{ route('jiris.create') }}">Créer un nouveau jiri
                </a>
            </div>
        </div>
        <table
            class="w-full overflow-hidden border-separate rounded-2xl bg-white border border-gray-300 border-spacing-0">
            <thead>
                <tr class="bg-gray-100 p-0">
                    <th class="px-4 py-2 w-[5%]">
                        <input class="all_col hover:cursor-pointer" type="checkbox" name="all_col_selector"
                               id="all_col"
                               title="Séléctionner tout les jiris">
                        <label for="all_col" class="sr-only">Séléctionner tout les jiris</label>
                    </th>
                    @foreach($labels as $label)
                        <th scope="col"
                            class="font-semibold text-gray-900 py-2 px-4 text-left min-w-[40%]">
                            <div class="flex items-center gap-2">
                                @if($label['arrow_filter'] ?? false)
                                    <a class="hover:cursor-pointer" href="{!! $label['route'] !!}">
                                        {!! $label['name'] !!}
                                        <svg class="rotate-180 inline" width="10" height="17" viewBox="0 0 10 17"
                                             fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M9.80111 9.48089C10.0663 9.84474 10.0663 10.4345 9.80111 10.7984L5.48011 16.7271C5.21492 17.091 4.78507 17.091 4.51989 16.7271L0.19889 10.7984C-0.0662961 10.4345 -0.0662961 9.84474 0.19889 9.48089C0.464077 9.11703 0.893926 9.11703 1.15911 9.48089L4.32095 13.8192L4.32095 -5.93649e-08L5.67905 0L5.67905 13.8192L8.84089 9.48089C9.10607 9.11703 9.53592 9.11703 9.80111 9.48089Z"
                                                fill="black"/>
                                        </svg>
                                    </a>
                                @else
                                    {!! $label['name'] !!}
                                @endif
                            </div>
                        </th>
                    @endforeach
                </tr>
            </thead>
            @foreach($this->jiris as $jiri)
                <tr wire:key="{!! $jiri->id !!}">
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
                    <td class="py-3 relative" x-data="{ open: false }">
                        <div @click="open = !open" class="hover:cursor-pointer">
                            <svg x-show="!open" class="inline"
                                 width="49" height="27" viewBox="0 0 49 27" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <circle cx="17.5" cy="13.5" r="1.5" fill="#101828"/>
                                <circle cx="24.5" cy="13.5" r="1.5" fill="#101828"/>
                                <circle cx="31.5" cy="13.5" r="1.5" fill="#101828"/>
                            </svg>
                            <span x-show="open">Fermer</span></div>
                        <div x-show="open" x-transition class="absolute p-2 bg-gray-50 border border-gray-200 z-[2]">
                            <a href="#" wire:click="delete({!! $jiri->id !!})">Supprimer</a>
                            <a href="#">Modifier</a>
                        </div>
                    </td>
                </tr>
            @endforeach
        </table>
    </section>
</main>
