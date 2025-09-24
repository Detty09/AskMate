@extends("layouts.main")

@section("title", "Add new answer")

@section('content')
    <div class="flex flex-col items-center mt-6 min-w-1/3">
        <x-header>Add new answer:</x-header>
        <div class="flex flex-col w-full max-w-3xl mt-6">
            <form action="/submit-answer" method="POST" class="flex flex-col gap-6">
                <input type="hidden" name="id_question" value="{{ $id_question }}">
                <textarea name="answer-message" placeholder="Type something..." required class="p-2 min-h-50 text-black border border-gray-200 rounded-xl"></textarea>
                <x-submit-button type="submit">Submit</x-submit-button>
            </form>
        </div>
    </div>
@endsection