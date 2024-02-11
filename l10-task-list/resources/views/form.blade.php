@extends('layouts.app')

@section('title', isset($task) ? 'Edit Task' : 'Add Task')

@section('styles')
    <style>
        .error-message {
            color: red;
            font-size: 0.8rem;
        }
    </style>
@endsection


@section('content')
    <form method="POST" action="{{ isset($task) ? route('tasks.update', ['task' => $task->id]) : route('tasks.store') }}">
        {{-- {{ $errors }} --}}
        {{-- csrf protect from attacks --}}
        @csrf
        @isset($task)
            @method('PUT')
        @endisset
        <div class="mb-4">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" value="{{ $task->title ?? old('title') }}"
                @class(['border-red-500' => $errors->has('title')])>
            @error('title')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="description">Description</label>
            <textarea name="description" id="description" rows="5" @class(['border-red-500' => $errors->has('description')])>
              {{ $task->description ?? old('description') }}
            </textarea>
            @error('description')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="long_description">Long Description</label>
            <textarea name="long_description" id="long_description" rows="10" @class(['border-red-500' => $errors->has('long_description')])>
              {{ $task->long_description ?? old('long_description') }}
            </textarea>
            @error('long_description')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center gap-2">
            <button type="submit" class="font-medium text-gray-700 rounded-md px-2 py-1 ring-1 ring-pink-500">
                @isset($task)
                    Update Task
                @else
                    Add Task
                @endisset
            </button>
            <a href="{{ route('tasks.index') }}"
                class="font-medium text-gray-700 rounded-md px-2 py-2 underline decoration-pink-500">Cancel</a>
        </div>
    </form>
@endsection
