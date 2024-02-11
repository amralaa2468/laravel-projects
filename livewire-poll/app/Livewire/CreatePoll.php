<?php

namespace App\Livewire;

use App\Models\Poll;
use Livewire\Component;

class CreatePoll extends Component
{
    public $title;
    public $options = [];

    protected $rules = [
        'title' => ['required', 'min:3', 'max:255'],
        'options' => ['required', 'array', 'min:1', 'max:10'],
        'options.*' => ['required', 'min:1', 'max:255'],
    ];

    protected $messages = [
        'options.*' => 'The option cannot be empty.',
    ];

    public function render()
    {
        return view('livewire.create-poll');
    }


    public function addOption()
    {
        $this->options[] = '';
        $this->validateOnly('options.*');
    }

    public function removeOption($index)
    {
        unset($this->options[$index]);

        //to adjust the index if you removed one from the middle then the index adjusts
        $this->options = array_values($this->options);
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function createPoll()
    {
        $this->validate();

        Poll::create([
            'title' => $this->title,
        ])->options()->createMany(
                collect($this->options)->map(fn($option) => ['name' => $option])
                    ->all()
            );

        // foreach ($this->options as $optionName) {
        //     $poll->options()->create(['name' => $optionName]);
        // }

        $this->reset(['title', 'options']);

        $this->dispatch('pollCreated');
    }

    // public function mount()
    // {

    // }
}
