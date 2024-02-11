<div>
    @forelse ($polls as $poll)
        <div class="mb-4">
            <h3 class="mb-4 text-xl">
                {{ $poll->title }}
            </h3>
            @foreach ($poll->options as $option)
                <div class="mb-2 flex items-center justify-between">
                    <button class="btn w-40" wire:click="vote({{ $option->id }})">Vote</button>

                    {{ $option->name }} ({{ $option->votes->count() }})
                </div>
            @endforeach
        </div>
        <hr class="my-2">
    @empty
        <div class="text-gray-500">
            No Polls Available
        </div>
    @endforelse
</div>
