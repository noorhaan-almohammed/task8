<!-- resources/views/auth/register.blade.php -->
@extends('layouts.app')

@section('content')
<h1>Register</h1>

<form action="{{ route('register.submit') }}" method="POST">
    @csrf
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" required>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>

    <button type="submit">Register</button>
</form>
@endsection
