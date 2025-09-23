<div>
    <a href="/display?id={{$question->id}}">
        <h3>{{$question->title}}</h3>
        <p>{{$question->submission_time}}</p>
    </a>
    <form action="/delete-question" method="POST">
        <input type="hidden" name="question_id" value="{{$question->id}}">
        <button type="submit">Delete</button>
    </form>
    <a href="/edit-question?id={{ $question->id }}">
        <button>Edit</button>
    </a>
</div>