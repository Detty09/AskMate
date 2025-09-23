@extends ("layouts.main")

@section("title", "User's questions")

@section("content")
    <div class="flex flex-col mx-auto mt-6 w-full">
        <x-header>My Questions</x-header>
        @if (empty($questions))
            <p>You have not asked any questions yet.</p>
        @else
            <div class="flex flex-col mt-6 w-full">
                @foreach ($questions as $question)
                    @include("question-item", ["question" => $question])
                @endforeach
            </div>
        @endif
    </div>

@endsection
