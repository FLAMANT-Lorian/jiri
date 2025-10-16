<!doctype html>
<html lang="{!! app()->getLocale() !!}">
<head>
    @include('partials.head')
</head>
<body class="bg-gray-100 m-auto flex">
    <header class="h-screen box-border p-6
    rounded-2xl rounded-bl-none rounded-tl-none
    bg-white border border-l-0 border-gray-300 flex flex-col">
        <h1 class="text-4xl pb-6 font-semibold flex flex-col gap-2">
            Bonjour,
            <span class="text-2xl font-normal text-orange-600">
            {!! auth()->user()->name !!}
        </span>
        </h1>
        <nav>
            @include('components.side-menu.side-menu')
        </nav>
        <a class="mt-auto font-medium block px-6 py-2.5 rounded-xl bg-red-100 border border-red-200 hover:bg-red-200 hover:border-red-300 transition-all"
           href="#"
           title="Me deconnecter">
            Me déconnecter
        </a>
    </header>
