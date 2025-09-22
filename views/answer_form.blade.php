@extends("layouts.main")

@section("title", "Add new answer")

@section('content')
    <h1>Add new answer:</h1>
    <form action="/submit-answer" method="POST">
        <input type="hidden" name="id_question" value="{{ $id_question }}">
        <textarea name="answer-message" required></textarea>
        <button type="submit">Submit</button>
    </form>
@endsection