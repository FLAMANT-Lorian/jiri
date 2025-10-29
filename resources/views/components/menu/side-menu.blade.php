@php

    $links = [
            ['label'=> 'Tableau de bord', 'title' => 'Voir le tableau de bord', 'destination' => route('dashboard.index')],
            ['label'=> 'Mes jiris', 'title' => 'Voir tout mes Jiris', 'destination' => route('jiris.index')],
            ['label'=> 'Mes contacts', 'title' => 'Voir tout mes contacts', 'destination' => route('contacts.index')],
            ['label'=> 'Mes projets', 'title' => 'Voir tout mes projets', 'destination' => route('projects.index')],
    ];

@endphp
<ul class="flex flex-col gap-2">
    @foreach($links as $link)
        <li>
            <a class=" font-medium block px-6 py-2.5 rounded-xl hover:bg-gray-100 hover:border-gray-300 transition-all
                        {!! url()->current() === $link['destination'] ? 'border border-gray-300 bg-gray-100' : 'border bg-white border-white' !!}"
               href="{!! $link['destination'] !!}"
               title="{!! $link['title'] !!}">
                {!! $link['label'] !!}
            </a>
        </li>
    @endforeach
</ul>
