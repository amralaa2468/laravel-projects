@extends('layouts.app')

@section('title', 'The List of tasks.')



@section('content')

    <nav class="mb-4">
        <a href="{{ route('tasks.create') }}" class="font-medium text-gray-700 rounded-md px-2 py-1 ring-1 ring-pink-500">
            AddTask
        </a>
    </nav>

    @forelse ($tasks as $task)
        <div class="mb-3">
            <a href="{{ route('tasks.show', ['task' => $task->id]) }}" @class(['line-through' => $task->completed])>
                {{ $task->title }}
            </a>
        </div>
    @empty
        <div>There are no tasks!</div>
    @endforelse

    @if ($tasks->count())
        <nav class="mt-5">
            {{ $tasks->links() }}
        </nav>
    @endif
@endsection
