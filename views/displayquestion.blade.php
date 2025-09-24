
@extends('layouts.main')

@section('title', 'Question')

@section('content')
    @if($question)
        <div class="flex flex-col w-full items-center p-4 gap-10">
            <div class="flex p-4 gap-10 items-center">
                @if($image)
                    <div class="my-4">
                        <img src="{{ $image->directory . $image->file_name }}"
                             alt="Question image"
                             class="w-32 h-auto rounded shadow-md">
                    </div>
                @endif
                <div>
                    <h3 class="text-5xl font-medium text-gray-900 text-center mb-5">{{ $question->title }}</h3>
                    <p class="text-xl font-normal text-gray-900 text-center">{{ $question->message }}</p>
                </div>
            </div>
            <div class="flex flex-col p-4 w-full gap-10 items-center">
                <div class="w-1/2">
                    <h5 class="text-xl font-medium text-gray-900 text-center mb-4">Answers: </h5>
                    @if (count($answers) > 0)
                            @foreach($answers as $answer)
                                <div class="w-full">
                                    <div class="border border-gray-200 rounded-xl shadow-sm p-6 mb-4">
                                        <div class="flex justify-between items-center">
                                            <div class="flex flex-col">
                                                <h3 class="text-xl font-medium text-black">{{$answer->message}}</h3>
                                            </div>
                                            @if(isset($_SESSION['user_id']) && $answer->id_registered_user == $_SESSION['user_id'])
                                                <div>
                                                    <form action="/answer-edit" method="GET" style="display:inline;">
                                                        <input type="hidden" name="id" value="{{ $answer->id }}">
                                                        <button type="submit"
                                                                class="px-3 py-1 text-sm text-white bg-yellow-500 rounded-lg hover:bg-yellow-300 transition-colors transition-transform duration-100 ease-in-out transform hover:scale-105">
                                                            <i class="fa-solid fa-pen"></i>
                                                        </button>
                                                    </form>
                                                    <form action="/answer-delete" method="POST" style="display:inline;">
                                                        <input type="hidden" name="id" value="{{ $answer->id }}">
                                                        <button type="submit"
                                                                onclick="return confirm('Are you sure you want to delete this answer?')"
                                                                class="px-3 py-1 text-sm text-white bg-red-600 rounded-lg hover:bg-red-400 transition-colors transition-transform duration-100 ease-in-out transform hover:scale-105">
                                                            <i class="fa-solid fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                    @else
                        <p class="text-center">No answers yet.</p>
                    @endif
                </div>
                <div class="flex justify-center">
                    @if(isset($_SESSION['user_id']))
                        <a href="/add-answer" class="inline-block text-black hover:underline focus:ring-1 font-medium rounded-lg text-sm px-5 py-2.5">
                            <x-submit-button>Add answer</x-submit-button>
                        </a>
                    @else
                        <p><em>You must be logged in to add an answer.</em></p>
                    @endif
                    @else
                        <h1>Question not found</h1>
                    @endif
                </div>
            </div>
        </div>
@endsection