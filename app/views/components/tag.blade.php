<div class="flex flex-row border-3 p-1 border-blue-700 rounded-lg space-x-1">
    <p>
        {{ $slot }}
    </p>
    <form class="inline" action="/relation/delete" method="POST">
        <input type="hidden" name="id_question" value="{{ $questionId }}">
        <input type="hidden" name="id_tag" value="{{ $tagId }}">
        <button type="submit">❌</button>
    </form>
</div>
