<div>
    <form wire:submit.prevent="createPoll">
        <label>Poll Title</label>

        <input type="text" wire:model.live="title">
        @error('title')
            <div class="text-red-500">{{ $message }}</div>
        @enderror

        {{-- Current title: {{ $title }} --}}

        <div class="mt-4 mb-4">
            <button class="btn" wire:click.prevent="addOption">Add Option</button>
        </div>

        <div>
            @foreach ($options as $index => $option)
                <div class="mb-4">
                    <label>Option {{ $index + 1 }}</label>
                </div>

                <div class="flex gap-2">
                    <input type="text" wire:model.lazy="options.{{ $index }}">

                    <button class="btn" wire:click.prevent="removeOption({{ $index }})">Remove</button>
                </div>
                @error('options.' . $index)
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
            @endforeach
        </div>

        <button type="submit" class="btn my-3">Create Poll</button>
    </form>
</div>
