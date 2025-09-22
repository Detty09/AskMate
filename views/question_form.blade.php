@extends("layouts.main")

@section("title", "Add new question")

@section('content')
    <h1>Add new question</h1>
    <form action="/submit-question" method="POST">
        <input type="text" name="question-title" placeholder="Question title">
        <input type="text" name="question-message" placeholder="Message">
        <button type="submit">Submit</button>
    </form>
@endsection