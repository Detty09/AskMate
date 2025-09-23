<div class="w-full max-w-3xl mx-auto">
    <div class="bg-gray-700 border border-gray-500 rounded-xl shadow-md p-6 mb-4">
        <div class="flex justify-between items-center">

            <div class="flex flex-col">
                <a href="/display?id={{ $question->id }}">
                    <h3 class="text-xl font-semibold text-white transition-transform duration-500 ease-in-out transform hover:scale-105">{{ $question->title }}</h3>
                </a>
                <p class="text-gray-400 text-sm">{{ $question->submission_time }}</p>
            </div>

            <div class="flex gap-3">
                <form action="/delete-question" method="POST">
                    <input type="hidden" name="question_id" value="{{ $question->id }}">
                    <button type="submit"
                            class="px-3 py-1 text-sm text-white bg-red-600 rounded-lg hover:bg-red-400 transition-colors transition-transform duration-500 ease-in-out transform hover:scale-105">
                        Delete
                    </button>
                </form>

                <a href="/edit-question?id={{ $question->id }}">
                    <button class="px-3 py-1 text-sm text-white bg-blue-700 rounded-lg hover:bg-blue-500 transition-colors transition-transform duration-500 ease-in-out transform hover:scale-105">
                        Edit
                    </button>
                </a>
            </div>
        </div>
    </div>
</div>
