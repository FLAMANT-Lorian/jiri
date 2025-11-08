<?php

use App\Models\Jiri;
use Livewire\Component;

new class extends Component {

    public Jiri $jiri;

    public function mount(string $model_id): void
    {
        $this->jiri = Jiri::findOrFail($model_id);
    }

    public function delete(): void
    {
        $this->jiri->delete();

        $this->dispatch('jiris_list_changed');
        $this->dispatch('close_modal');
    }
};
?>

<button wire:click="delete()"
        class="hover:cursor-pointer px-2 py-1 hover:bg-white border border-transparent rounded-xl hover:border-gray-200">
    Êtes-vous sûr ?
</button>
