@props(['labels', 'all_selector', 'table_title', 'sort', 'checkbox', 'order'])

<table
    class="w-full overflow-hidden border-separate rounded-2xl bg-white border border-gray-300 border-spacing-0">
    <thead>
        <tr class="bg-gray-100 p-0">
            @if($all_selector)
                <th class="px-4 py-2 w-[5%]">
                    <input class="all_col hover:cursor-pointer" type="checkbox" name="all_col_selector"
                           id="all_col"
                           title="Séléctionner tout les {!! $table_title !!}">
                    <label for="all_col" class="sr-only">Séléctionner tout les {!! $table_title !!}</label>
                </th>
            @endif
            @foreach($labels as $label)
                <th scope="col"
                    class="font-semibold text-gray-900 py-2 {!! $all_selector ? '' : 'px-4'!!} text-left min-w-[40%]">
                    <div class="flex items-center gap-2">
                        @if($label['arrow_filter'] ?? false)
                            <a class="hover:cursor-pointer" href="{!! $label['route'] !!}">
                                {!! $label['name'] !!}
                                @if($order === 'asc' && $sort === $label['sort'])
                                    <svg class="rotate-180 inline" width="10" height="17" viewBox="0 0 10 17"
                                         fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M9.80111 9.48089C10.0663 9.84474 10.0663 10.4345 9.80111 10.7984L5.48011 16.7271C5.21492 17.091 4.78507 17.091 4.51989 16.7271L0.19889 10.7984C-0.0662961 10.4345 -0.0662961 9.84474 0.19889 9.48089C0.464077 9.11703 0.893926 9.11703 1.15911 9.48089L4.32095 13.8192L4.32095 -5.93649e-08L5.67905 0L5.67905 13.8192L8.84089 9.48089C9.10607 9.11703 9.53592 9.11703 9.80111 9.48089Z"
                                            fill="black"/>
                                    </svg>
                                @else
                                    <svg class="inline" width="10" height="17" viewBox="0 0 10 17"
                                         fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M9.80111 9.48089C10.0663 9.84474 10.0663 10.4345 9.80111 10.7984L5.48011 16.7271C5.21492 17.091 4.78507 17.091 4.51989 16.7271L0.19889 10.7984C-0.0662961 10.4345 -0.0662961 9.84474 0.19889 9.48089C0.464077 9.11703 0.893926 9.11703 1.15911 9.48089L4.32095 13.8192L4.32095 -5.93649e-08L5.67905 0L5.67905 13.8192L8.84089 9.48089C9.10607 9.11703 9.53592 9.11703 9.80111 9.48089Z"
                                            fill="black"/>
                                    </svg>
                                @endif
                            </a>
                        @else
                            {!! $label['name'] !!}
                        @endif
                    </div>
                </th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        {!! $slot !!}
    </tbody>
</table>
