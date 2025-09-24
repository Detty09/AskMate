@extends("layouts.main")

@section("title", "Edit answer")

@section('content')
    @if($answer)
        <div class="flex flex-col items-center mt-6 min-w-1/3">
            <x-header>Edit answer message:</x-header>
            <div class="flex flex-col w-full max-w-3xl mt-6">
                <form action="/answer-update" method="POST" class="flex flex-col gap-6">
                    <input type="hidden" name="id" value="{{ $answer->id }}">
                    <textarea name="answer-message"  id="message" required class="p-2 min-h-50 text-black border border-gray-200 rounded-xl">{{$answer->message}}</textarea>
                    <x-submit-button type="submit">Submit</x-submit-button>
                </form>
            </div>
        </div>
    @else
        <p>Answer not found</p>
    @endif
@endsection