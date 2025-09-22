@extends('layouts.main')

@section('title', 'Login')

@section('content')
    <h1>Welcome back!</h1>
    <form action="/login" method="POST">
        <div>
            <div>
                <label for="email">Email Address:</label>
                <input type="email" name="email" placeholder="user@example.com">
            </div>
            <div>
                <label for="password">Password:</label>
                <input type="password" name="password">
            </div>
        </div>

        @if(isset($error))
            <div>
                <p>{{ $error }}</p>
            </div>
        @endif

        <button type="submit">Login</button>
    </form>
@endsection