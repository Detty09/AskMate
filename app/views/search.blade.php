@php
    $questions = $questions ?? [];
    $answers = $answers ?? [];
    if (is_object($questions)) $questions = (array) $questions;
    if (is_object($answers)) $answers = (array) $answers;
@endphp
@extends('layouts.main')

@section('title', 'Search')

@section('content')
    <div class="flex flex-col items-center mt-6 space-y-6">
    @if(count($questions) > 0 || count($answers) > 0)
        <x-header>Search results for "{{ $query }}"</x-header>

        @if(count($questions) > 0)
            <h3>Questions:</h3>
            @foreach($questions as $q)
                <p>Title: {{ $q->title ?? $q->question_title }} - {{ $q->message ?? $q->question_message }}</p>
            @endforeach
        @endif

        @if(count($answers) > 0)
            <h3>Answers:</h3>
            @foreach($answers as $a)
                <p>Message: {{ $a->message ?? $a->answer_message }} (From: {{ $a->question_title ?? $a->title ?? 'Unknown Question' }})</p>
            @endforeach
        @endif
    @else
        <p>No results found.</p>
        @endif
        </div>
        @endsection