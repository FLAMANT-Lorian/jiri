<!doctype html>
<html lang="{!! app()->getLocale() !!}" class="overflow-x-hidden">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{!! $title ?? 'Jiri • Gérer vos jiris facilement' !!}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 m-auto flex">

    {{--HEADER--}}
    @include('components.header')

    {{--MAIN--}}
    {!! $slot !!}

    <livewire:widgets::modal />

    {{--FOOTER--}}
    @include('components.footer')
</body>
</html>
