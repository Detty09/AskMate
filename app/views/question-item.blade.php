<div class="w-full max-w-3xl mx-auto">
    <div class="bg-gray-700 border border-gray-500 rounded-xl shadow-md p-6 mb-4">
        <div class="flex justify-between items-center">

            <div class="flex flex-col">
                <a href="/display?id={{ $question->id }}">
                    <h3 class="text-xl font-semibold text-white transition-transform duration-100 ease-in-out transform hover:scale-105">{{ $question->title }}</h3>
                </a>
                <p class="text-gray-400 text-sm">{{ $question->submission_time }}</p>
            </div>

            <div class="flex gap-3">
                @if ($mode === "myquestions")
                    <form action="/delete-question" method="POST">
                        <input type="hidden" name="question_id" value="{{ $question->id }}">
                        <button type="submit"
                                class="px-3 py-1 text-sm text-white bg-red-600 rounded-lg hover:bg-red-400 transition-colors transition-transform duration-100 ease-in-out transform hover:scale-105">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </form>

                    <a href="/edit-question?id={{ $question->id }}">
                        <button class="px-3 py-1 text-sm text-white bg-yellow-500 rounded-lg hover:bg-yellow-300 transition-colors transition-transform duration-100 ease-in-out transform hover:scale-105">
                            <i class="fa-solid fa-pen"></i>
                        </button>
                    </a>
                @else
                    <div class="flex flex-col items-center text-sm text-gray-300">
                        <div class="flex gap-5">
                            <a href="/question/vote?id={{ $question->id }}&inc=1"
                               class="text-green-400 hover:text-green-300 transition-colors text-xl transition-transform duration-100 ease-in-out transform hover:scale-105">
                                <i class="fas fa-thumbs-up"></i>
                            </a>
                            <a href="/question/vote?id={{ $question->id }}&inc=-1"
                               class="text-red-400 hover:text-red-300 transition-colors text-xl transition-transform duration-100 ease-in-out transform hover:scale-105">
                                <i class="fas fa-thumbs-down"></i>
                            </a>
                        </div>
                        <div>
                            <span style="font-size: 0.8em; color: #888;">(Votes: {{ $question->vote_number }})</span>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
