@extends('layouts.main')

@section('title', 'All Questions')

@section('content')
    <div class="flex flex-col mx-auto mt-6 w-full">
        <x-header>Latest Questions</x-header>
        @if (empty($questions))
            <p>No questions yet.</p>
        @else
            <div class="flex flex-col mt-6 w-full">
                @foreach ($questions as $question)
                    @include("question-item", ["question" => $question, "mode" => "main"])
                @endforeach
            </div>
        @endif
    </div>
@endsection
