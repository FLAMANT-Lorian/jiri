<!doctype html>
<html lang="{!! app()->getLocale() !!}">
<head>
    @include('partials.head')
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

