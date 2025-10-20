<!doctype html>
<html lang="{!! app()->getLocale() !!}">
<head>
    <x-partials.head>
        <x-slot:title>
            {!! $title !!}
        </x-slot:title>
    </x-partials.head>
</head>
<body class="bg-gray-100 m-auto flex">

    {{--HEADER--}}
    @include('components.header')

    {{--MAIN--}}
    {!! $slot !!}

    {{--FOOTER--}}
    @include('components.footer')
</body>
</html>
