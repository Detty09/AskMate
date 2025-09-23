@extends('layouts.main')

@section('title', 'User List')

@section('content')
    <div class="flex flex-col items-center mx-auto mt-6">
        <x-header>Question Tags</x-header>

        <div class="relative overflow-x-auto shadow-md rounded-lg mt-6">
            <table class="w-full text-2xl text-left rtl:text-right border-4 border-gray-800 text-gray-400">
                <thead class="text-xs uppercase text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3 bg-gray-700">
                        ID
                    </th>
                    <th scope="col" class="px-6 py-3 bg-gray-800">
                        Tag
                    </th>
                    <th scope="col" class="px-6 py-3 bg-gray-700">
                        Questions
                    </th>
                </tr>
                </thead>


                @if($tags)
                    <tbody>
                    @foreach($tags as $tag)
                        <tr class="border-b border-gray-800">
                            <td class="px-6 py-4 bg-gray-700">
                                {{ $tag['id'] }}
                            </td>
                            <td class="px-6 py-4 font-medium whitespace-nowrap text-white bg-gray-800">
                                {{ $tag['name'] }}
                            </td>
                            <td class="px-6 py-4 bg-gray-700">
                                {{ $tag['questions'] }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                @else
                    <tbody>
                    <tr class="px-6 py-4 bg-gray-800 text-center">
                        <td colspan="3" >No tags yet</td>
                    </tr>
                    </tbody>
                @endif

            </table>
        </div>
    </div>
@endsection
