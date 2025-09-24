
@extends('layouts.main')

@section('title', 'Question')

@section('content')
    @if($question)
        <div class="mx-auto max-w-3xl p-4 space-y-3">
        <x-header>Question ID: {{$question->id}}</x-header>
    <h3>Title: {{ $question->title }}</h3>
    <p>Details: {{ $question->message }}</p>
            @if($image)
                <div class="my-4">
                    <img src="{{ $image->directory . $image->file_name }}"
                         alt="Question image"
                         class="w-32 h-auto rounded shadow-md">
                </div>
            @endif
        <h3>Answers: </h3>
        @if (count($answers) > 0)
        <ul>
            @foreach($answers as $answer)
                <div>
                <li>{{$answer->message}}</li>
                    <a href="/answer/vote?id={{ $answer->id }}&inc=1"
                        class="text-green-400 hover:text-green-300 transition-colors text-xl transition-transform duration-100 ease-in-out transform hover:scale-105">
                        <i class="fas fa-thumbs-up"></i></a>
                    <a href="/answer/vote?id={{ $answer->id }}&inc=-1"
                        class="text-red-400 hover:text-red-300 transition-colors text-xl transition-transform duration-100 ease-in-out transform hover:scale-105">
                        <i class="fas fa-thumbs-down"></i></a>
                    <span class="ml-2 text-gray-600">Votes: {{$answer->vote_number}}</span>
                @if(isset($_SESSION['user_id']) && $answer->id_registered_user == $_SESSION['user_id'])
                        <form action="/answer-edit" method="GET" style="display:inline;">
                            <input type="hidden" name="id" value="{{ $answer->id }}">
                            <x-submit-button type="submit">Edit</x-submit-button>
                        </form>
                    <form action="/answer-delete" method="POST" style="display:inline;">
                        <input type="hidden" name="id" value="{{ $answer->id }}">
                        <x-submit-button type="submit" onclick="return confirm('Are you sure you want to delete this answer?')">
                            Delete
                        </x-submit-button>
                    </form>
                @endif
                </div>
            @endforeach
        </ul>
        @else
            <p>No answers yet.</p>
            @endif
        @if(isset($_SESSION['user_id']))
        <a href="/add-answer" class="inline-block text-black hover:underline focus:ring-1 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">Add answer</a>
        @else
            <p><em>You must be logged in to add an answer.</em></p>
        @endif
    @else
        <h1>Question not found</h1>
    @endif
        </div>
@endsection