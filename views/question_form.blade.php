@extends("layouts.main")

@section("title", isset($question) ? "Edit question" : "Add new question")

@section('content')
    <div class="flex flex-col items-center mt-6 min-w-1/3">
        <x-header>{{ isset($question) ? "Edit question" : "Add new question" }}</x-header>

        <div class="flex flex-col w-full max-w-3xl p-6 mt-6 border rounded-lg bg-gray-700 border-gray-500 items-center shadow-lg">
            <form action= {{ isset($question) ? "/update-question" : "/submit-question" }} method="POST"
                  class="min-w-full flex flex-col gap-10"
            >
                @csrf
                @if ( isset($question) )
                    <div>
                        <input type="hidden" name="question-id" value="{{$question->id}}">
                    </div>
                @endif
                <div>
                    <label for="question-title" class="mt-5 text-md font-medium text-white">
                        Title
                    </label>
                    <input
                            type="text"
                            name="question-title"
                            value="{{ isset($question) ? htmlspecialchars($question->title) : "" }}"
                            placeholder="What is your question?"
                            required
                            class="block py-2.5 px-0 w-full text-sm bg-transparent border-0 border-b-2 appearance-none text-white border-gray-600 focus:border-blue-500 focus:outline-none focus:ring-0 peer"
                    >
                </div>
                <div>
                    <label for="question-title" class="mt-5 text-md font-medium text-white">
                        Message
                    </label>
                    <input
                            type="text"
                            name="question-message"
                            placeholder="Details..."
                            value="{{ isset($question) ? htmlspecialchars($question->message) : "" }}"
                            required
                            class="block py-2.5 px-0 w-full text-sm bg-transparent border-0 border-b-2 appearance-none text-white border-gray-600 focus:border-blue-500 focus:outline-none focus:ring-0 peer"
                    >
                </div>


                <div class="flex justify-center mt-6">
                    <x-submit-button>Update</x-submit-button>
                </div>
            </form>

            <x-add-tag></x-add-tag>
        </div>
    <div>


@endsection