@extends("layouts.main")

@section("title", "Add new answer")

@section('content')
    <h1>Add new answer:</h1>
    <form action="/submit-answer" method="POST">
        <input type="hidden" name="id_question" value="{{ $id_question }}">
        <textarea name="answer-message" required></textarea>
        <x-submit-button type="submit">Submit</x-submit-button>
    </form>
@endsection