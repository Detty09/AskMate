@extends("layouts.main")

@section("title", "Add new answer")

@section('content')
    <h1>Add new answer:</h1>
    <form action="/submit-answer" method="POST">
        <input type="text" name="answer-message" placeholder="Message">
        <button type="submit">Submit</button>
    </form>
@endsection