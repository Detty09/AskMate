@extends ("layouts.main")

@section("title", "User's questions")

@section("content")
    <h1>My Questions</h1>

    @if (empty($questions))
        <p>You have not asked any questions yet.</p>
    @else
        @foreach ($questions as $question)
            @include("question-item", ["question" => $question])
        @endforeach
    @endif
@endsection
