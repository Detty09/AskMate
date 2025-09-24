<div>
    <p class="mt-5 text-md font-medium text-white">
        Tags
    </p>
    <div class="flex flex-row flex-wrap space-x-2 block py-2.5 px-0 max-w-max text-sm bg-transparent border-0 border-b-2 appearance-none text-white border-gray-600 focus:border-blue-500 focus:outline-none focus:ring-0 peer">
            @foreach($questionTags as $questionTag)
                    <?php
                    $qId = $questionTag['id_question'];
                    $tId = $questionTag['id_tag'];
                    $name = $questionTag['name'];
                    ?>
                <x-tag questionId="$qId" tagId="$tId">
                    {{ $name }}
                </x-tag>
            @endforeach
    </div>
</div>