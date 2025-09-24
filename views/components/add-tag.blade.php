@if(isset($error))
    <x-error>{{ $error }}</x-error>
@endif

<div class="min-w-full flex flex-col gap-10">

    <x-tag-list></x-tag-list>

    <div>
        <form action="/tags" method="POST" class="mt-6">
            @csrf
            <input type="hidden" name="question-id" value="{{$question->id}}">
            <div class="flex items-center space-x-6">
                <select name="tag-id" class="text-white bg-gray-700">
                    <option value="" disabled selected>Choose tag</option>
                    @foreach($tags as $tag)
                        <option value="{{ $tag['id'] }}">{{ $tag['name'] }}</option>
                    @endforeach
                </select>

                <x-submit-button>Add tag</x-submit-button>
            </div>
        </form>

        <form action="/tags" method="POST">
            @csrf
            <input type="hidden" name="question-id" value="{{$question->id}}">
            <div class="relative z-0 w-full mb-5 group mt-6">
                <input type="text" name="tag" id="tag"
                       class="block py-2.5 px-0 w-full text-sm bg-transparent border-0 border-b-2 appearance-none text-white border-gray-600 focus:border-blue-500 focus:outline-none focus:ring-0 peer"
                       placeholder=""/>
                <label for="tag"
                       class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-500 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-95 peer-focus:-translate-y-6">New
                    Tag</label>
            </div>

            <x-submit-button>Add tag</x-submit-button>
        </form>
    </div>

</div>

