<div class="relative flex flex-col gap-1 col-span-3">
    <input type="hidden" name="MAX_FILE_SIZE" value="300000"/>
    <label for="{!! $id !!}" class="font-semibold">{!! $slot !!}
        @if($required)
            <small class="text-red-500"> *</small>
        @endif
    </label>
    <input
        @if($required)
            required
        @endif
        class="py-1 px-2 rounded-lg outline-1 outline-gray-300 focus:outline-blue-500" type="file" name="{!! $name !!}" id="{!! $id !!}">
    @error($name)
    <p class="absolute -bottom-6 error text-red-500">{{ $message }}</p>
    @enderror
</div>
