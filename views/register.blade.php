@extends('layouts.main')

@section('title', 'Register')

@section('content')
    <h1>Register now!</h1>
    <form action="/register" method="POST">
        <div>
            <div>
                <label for="email">Email Address:</label>
                <input type="email" name="email" placeholder="user@example.com">
            </div>
            <div>
                <label for="email_confirmation">Confirm Email:</label>
                <input type="email" name="email_confirmation" placeholder="user@example.com">
            </div>
            <div>
                <label for="password">Password:</label>
                <input type="password" name="password">
            </div>
        </div>

        <button type="submit">Register</button>
    </form>
@endsection