<!doctype html>
<html lang="{!! app()->getLocale(); !!}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Jiri · Se connecter</title>
    @vite('resources/css/app.css', 'resources/js/app.js')
</head>
<body class="bg-gray-100 flex justify-center items-center min-h-screen">
    <section class="p-8 max-w-lg bg-white rounded-2xl">
        <a class="flex flex-row gap-2 items-center text-blue-500 hover:text-blue-700 pb-6" href="{!! route('login') !!}">
            <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" viewBox="0 0 16 16" fill="none">
                <path d="M5 1H4L0 5L4 9H5V6H11C12.6569 6 14 7.34315 14 9C14 10.6569 12.6569 12 11 12H4V14H11C13.7614 14 16 11.7614 16 9C16 6.23858 13.7614 4 11 4H5V1Z" fill="#000000"/>
            </svg>Retour</a>
        <h1 class="text-3xl font-medium text-center mb-6">
            Mot de passe oublié ?
        </h1>
        <p class="pb-2 text-sm">Les champs renseignés avec <span class="text-blue-500">*</span> sont obligatoires</p>
        <form class="flex flex-col" action="/forgot-password" method="post" novalidate>
            @csrf
            <fieldset class="flex flex-col">
                <legend class="hidden">Rénitialiser le mot de passe</legend>
                <div class="flex flex-col pb-6 relative">
                    <label class="pb-1" for="email">Adresse e-mail<small class="text-blue-500"> *</small></label>
                    <input class="p-2 border-1 border-gray-300 rounded-lg" type="email" name="email" id="email"
                           value="{!! old('email') !!}">
                    @error('email')
                    <p class="text-sm absolute text-red-500 top-18">{{ $message }}</p>
                    @enderror
                </div>
            </fieldset>
            <button
                class="py-2 text-center bg-blue-500 text-white rounded-lg hover:bg-blue-700 transition-all">Rénitialiser mon mot de passe</button>
        </form>
    </section>
</body>
</html>
