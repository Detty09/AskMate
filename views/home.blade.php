@extends('layouts.main')

@section('title', 'Home Page')

@section('content')
    <h1>Hello, {{ $name }}!</h1>
    <form action="/submit" method="POST">
        <input type="text" name="value" placeholder="Type something">
        <button type="submit">Submit</button>
    </form>
@endsection
