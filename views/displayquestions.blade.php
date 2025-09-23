<?php
@extends('layouts.main')

@section('title', 'All Questions')

@section('content')
    <h1>All Questions</h1>
    @if(isset($questions) && count($questions) > 0)
        <ul>
            @foreach ($questions as $question)
                <li>
                    <h2>{{ $question->title }}</h2>
                    <p>{{ $question->message }}</p>
                    <small>Submitted: {{ $question->submission_time }}</small>
                </li>
            @endforeach
        </ul>
    @else
        <p>No questions found.</p>
    @endif
@endsection
