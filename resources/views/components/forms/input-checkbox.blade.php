<div class="flex flex-row gap-3 col-start-1 row-start-{!! $value !!}">
    <input type="checkbox"
           name="{!! $name !!}"
           value="{!! $value !!}"
           id="{!! $id !!}">
    <label for="{!! $id !!}">{!! $slot !!}</label>
</div>
