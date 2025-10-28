<div class="relative flex flex-col gap-1 col-span-3">
    <label for="{!! $name !!}" class="font-semibold">{!! $slot !!}
        @if($required)
            <small class="text-red-500"> *</small>
        @endif
    </label>
    <input type="{!! $type !!}"
           placeholder="{!! $placeholder ?? '' !!}"
           class="py-1 px-2 rounded-lg outline-1 outline-gray-300 focus:outline-blue-500"
           name="{!! $name !!}" id="{!! $name !!}" value="{!! old($name) !!}"
    autocomplete="off">
    @error($name)
    <p class="absolute -bottom-6 error text-red-500">{{ $message }}</p>
    @enderror
</div>
