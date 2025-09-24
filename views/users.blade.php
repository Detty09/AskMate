@extends('layouts.main')

@section('title', 'User List')

@section('content')
    <div class="flex flex-col items-center mx-auto mt-6">
        <x-header>Registered Users</x-header>

        <div class="relative overflow-x-auto shadow-md rounded-lg mt-6 border border-gray-500">
            <table class="w-full text-xl text-left rtl:text-right text-gray-400">
                <thead class="text-xs uppercase text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3 bg-gray-700">
                        ID
                    </th>
                    <th scope="col" class="px-6 py-3 bg-gray-800">
                        Email
                    </th>
                    <th scope="col" class="px-6 py-3 bg-gray-700">
                        Registration date
                    </th>
                    <th scope="col" class="px-6 py-3 bg-gray-800">
                        Questions
                    </th>
                    <th scope="col" class="px-6 py-3 bg-gray-700">
                        Answers
                    </th>
                </tr>
                </thead>

                <tbody>
                @foreach($users as $user)
                    <tr class="border-b border-gray-800">
                        <td class="px-6 py-4 bg-gray-700">
                            {{ $user['id'] }}
                        </td>
                        <td class="px-6 py-4 font-medium whitespace-nowrap text-white bg-gray-800">
                            {{ $user['email'] }}
                        </td>
                        <td class="px-6 py-4 bg-gray-700">
                            {{ $user['registration_date'] }}
                        </td>
                        <td class="px-6 py-4 bg-gray-800">
                            {{ $user['questions']}}
                        </td>
                        <td class="px-6 py-4 bg-gray-700">
                            {{ $user['answers']}}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection