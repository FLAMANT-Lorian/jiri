<?php

use Livewire\Attributes\On;
use Livewire\Component;

new class extends Component {

    public ?string $current = null;
    public string $key = '';
    public string $model_id = '';

    #[On('open_modal')]
    public function open(array $payload): void
    {
        $this->current = $payload['form'];

        $this->model_id = $payload['model_id'];
    }

    #[On('close_modal')]
    public function close(): void
    {
        $this->current = null;
    }

};
?>

<div class="absolute h-screen z-[3] bg-gray-50 border-l border-l-gray-200 p-6 duration-200 ease-in-out {{ $this->current ? 'right-0' : '-right-[100%]' }}">
    @if(!is_null($current))
        <livewire:is :component="$current" :key="$key" :model_id="$model_id"/>
    @endif
</div>
