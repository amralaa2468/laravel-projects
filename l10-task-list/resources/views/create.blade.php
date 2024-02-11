@extends('layouts.app')

@section('title', 'Add Task')

@section('styles')
    <style>
        .error-message {
            color: red;
            font-size: 0.8rem;
        }
    </style>
@endsection


@section('content')
    @include('form')
@endsection
