<!-- resources/views/tasks/create.blade.php -->
@extends('layouts.app')

@section('content')
<h1>Create Task</h1>

<form action="{{ route('tasks.store') }}" method="POST">
    @csrf
    <label for="title">Title:</label>
    <input type="text" id="title" name="title" required>

    <label for="description">Description:</label>
    <textarea id="description" name="description" required></textarea>

    <button type="submit">Create Task</button>
</form>
@endsection
