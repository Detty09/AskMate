@extends("layouts.main")

@section("title", "Edit answer")

@section('content')
    @if($answer)
    <h1>Edit answer message:</h1>
    <form action="/answer-update" method="POST">
        <input type="hidden" name="id" value="{{ $answer->id }}">
        <textarea name="answer-message"  id="message" required>{{$answer->message}}</textarea>
        <button type="submit">Submit</button>
    </form>
    @else
        <p>Answer not found</p>
    @endif
@endsection