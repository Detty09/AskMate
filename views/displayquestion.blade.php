
@extends('layouts.main')

@section('title', 'Question')

@section('content')
    @if($question)
        <h1>Question</h1>
    <h5>Title: {{ $question->title }}</h5>
    <p>Details: {{ $question->message }}</p>
        <h5>Answers:</h5>
        @if (count($answers) > 0)
        <ul>
            @foreach($answers as $answer)
                <li>{{$answer->message}}</li>
            @endforeach
        </ul>
        @else
            <p>No answers yet.</p>
            @endif
    @else
        <h1>Question not found</h1>
    @endif
@endsection