@extends('layouts.main')

@section('title', 'All Questions')

@section('content')
    <h1>All Questions</h1>
    @if(isset($questions) && count($questions) > 0)
        <ul>
            @foreach ($questions as $question)
                <li>
                    <h2>{{ $question->title }} <span style="font-size: 0.8em; color: #888;">(Votes: {{ $question->vote_number }})</span></h2>
                    <a href="/question/vote?id={{ $question->id }}&inc=1">Vote up</a>
                    <a href="/question/vote?id={{ $question->id }}&inc=-1">Vote down</a>
                    <p>{{ $question->message }}</p>
                    <small>Submitted: {{ $question->submission_time }}</small>

                </li>
            @endforeach
        </ul>
    @else
        <p>No questions found.</p>
    @endif
@endsection
