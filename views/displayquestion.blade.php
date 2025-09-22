@extends('layouts.main')

@section('title', 'Question')

@section('content')
    @if($question)
        <h1>Question</h1>
    <h5>Title: {{ $question->title }}</h5>
    <p>Details: {{ $question->message }}</p>
    @else
        <h1>Question not found</h1>
    @endif
@endsection