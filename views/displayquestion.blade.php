
@extends('layouts.main')

@section('title', 'Question')

@section('content')
    @if($question)
        <h1>Question</h1>
    <h3>Title: {{ $question->title }}</h3>
    <p>Details: {{ $question->message }}</p>
        <h3>Answers:</h3>
        @if (count($answers) > 0)
        <ul>
            @foreach($answers as $answer)
                <li>{{$answer->message}}</li>
            @endforeach
        </ul>
        @else
            <p>No answers yet.</p>
            @endif
        <a href="/add-answer">Add answer</a>
    @else
        <h1>Question not found</h1>
    @endif

@endsection