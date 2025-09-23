@extends("layouts.main")

@section("title", isset($question) ? "Edit question" : "Add new question")

@section('content')
    <h1>{{ isset($question) ? "Edit question" : "Add new question" }}</h1>
    <form action= {{ isset($question) ? "/update-question" : "/submit-question" }} method="POST">

        @if ( isset($question) )
            <input type="hidden" name="question-id" value="{{$question->id}}">
        @endif
        <input
                type="text"
                name="question-title"
                value="{{ isset($question) ? htmlspecialchars($question->title) : "" }}"
                placeholder="Question title"
                required>
        <input
                type="text"
                name="question-message"
                placeholder="Message"
                value="{{ isset($question) ? htmlspecialchars($question->message) : "" }}"
                required>
        <button type="submit">Submit</button>
    </form>
@endsection