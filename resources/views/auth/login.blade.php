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
        <svg class="fill-blue-950 m-auto pb-2" xmlns="http://www.w3.org/2000/svg"
             xmlns:xlink="http://www.w3.org/1999/xlink" height="100px" width="100px" version="1.1" id="_x32_"
             viewBox="0 0 512 512" xml:space="preserve">
            <g>
                <path class="st0"
                      d="M505.837,180.418L279.265,76.124c-7.349-3.385-15.177-5.093-23.265-5.093c-8.088,0-15.914,1.708-23.265,5.093   L6.163,180.418C2.418,182.149,0,185.922,0,190.045s2.418,7.896,6.163,9.627l226.572,104.294c7.349,3.385,15.177,5.101,23.265,5.101   c8.088,0,15.916-1.716,23.267-5.101l178.812-82.306v82.881c-7.096,0.8-12.63,6.84-12.63,14.138c0,6.359,4.208,11.864,10.206,13.618   l-12.092,79.791h55.676l-12.09-79.791c5.996-1.754,10.204-7.259,10.204-13.618c0-7.298-5.534-13.338-12.63-14.138v-95.148   l21.116-9.721c3.744-1.731,6.163-5.504,6.163-9.627S509.582,182.149,505.837,180.418z"/>
                <path class="st0"
                      d="M256,346.831c-11.246,0-22.143-2.391-32.386-7.104L112.793,288.71v101.638   c0,22.314,67.426,50.621,143.207,50.621c75.782,0,143.209-28.308,143.209-50.621V288.71l-110.827,51.017   C278.145,344.44,267.25,346.831,256,346.831z"/>
            </g>
        </svg>
        <h1 class="text-3xl font-medium text-center mb-6">
            {!! __('login-view.identify_yourself') !!}
        </h1>
        <p class="pb-2 text-sm">Les champs renseignés avec <span class="text-blue-500">*</span> sont obligatoires</p>
        <form class="flex flex-col" action="{!! route('login.store') !!}" method="post" novalidate>
            @csrf
            <fieldset class="flex flex-col">
                <legend class="hidden">Créer un compte</legend>
                <div class="flex flex-col pb-6 relative">
                    <label class="pb-1" for="email">Adresse e-mail<small class="text-blue-500"> *</small></label>
                    <input class="p-2 border-1 border-gray-300 rounded-lg" type="email" name="email" id="email"
                           value="{!! old('email') !!}">
                    @error('email')
                    <p class="text-sm absolute text-red-500 top-18">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex flex-col pb-6 relative">
                    <label class="pb-1" for="password">Mot de passe<small class="text-blue-600"> *</small></label>
                    <input class="p-2 border-1 border-gray-300 rounded-lg" type="password" name="password" id="password" value="{!! old('password') !!}">
                    @error('password')
                    <p class="text-sm absolute text-red-500 top-18">{{ $message }}</p>
                    @enderror
                    <img src="{!! asset('assets/img/eye-off.svg') !!}" class="max-w-5 absolute top-10 right-4" alt="Oeil fermé">
                </div>
                <div class="flex flex-row justify-between pb-6">
                    <div class="fields">
                        <input type="checkbox" name="remember_me" id="remember_me">
                        <label for="remember_me" class="pl-1">Se souvenir de moi</label>
                    </div>
                    <a href="/forgot-password" class="text-blue-500 hover:text-blue-700">Mot de passe oublié ?</a>
                </div>
            </fieldset>
            <button
                class="py-2 text-center bg-blue-500 text-white rounded-lg hover:bg-blue-700 transition-all">{!! __('login-view.login_button') !!}</button>
        </form>
        <p class="mt-4 text-center">Pas encore de compte ?
            <a href="{!! route('register') !!}" class="text-blue-500 pl-1 hover:text-blue-700">Créer un compte</a>
        </p>
    </section>
</body>
</html>
