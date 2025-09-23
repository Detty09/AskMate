
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
                <div>
                <li>{{$answer->message}}</li>
                @if(isset($_SESSION['user_id']) && $answer->id_registered_user == $_SESSION['user_id'])
                        <form action="/answer-edit" method="GET" style="display:inline;">
                            <input type="hidden" name="id" value="{{ $answer->id }}">
                            <button type="submit">Edit</button>
                        </form>
                    <form action="/answer-delete" method="POST" style="display:inline;">
                        <input type="hidden" name="id" value="{{ $answer->id }}">
                        <button type="submit" onclick="return confirm('Are you sure you want to delete this answer?')">
                            Delete
                        </button>
                    </form>
                @endif
                </div>
            @endforeach
        </ul>
        @else
            <p>No answers yet.</p>
            @endif
        @if(isset($_SESSION['user_id']))
        <a href="/add-answer">Add answer</a>
        @else
            <p><em>You must be logged in to add an answer.</em></p>
        @endif
    @else
        <h1>Question not found</h1>
    @endif

@endsection