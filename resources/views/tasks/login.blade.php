<!-- resources/views/auth/login.blade.php -->
@extends('layouts.app')

@section('content')
<h1>Login</h1>

<form action="{{ route('login.submit') }}" method="POST">
    @csrf
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>

    <button type="submit">Login</button>
</form>
@endsection
