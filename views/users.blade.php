@extends('layouts.main')

@section('title', 'User List')

@section('content')
    <h1>Registered Users</h1>

    <table>
        <tr>
            <td>
                ID
            </td>
            <td>
                Email
            </td>
            <td>
                Registration date
            </td>
            <td>
                Questions
            </td>
            <td>
                Answers
            </td>
        </tr>

        @foreach($users as $user)
            <tr>
                <td>
                    {{ $user['id'] }}
                </td>
                <td>
                    {{ $user['email'] }}
                </td>
                <td>
                    {{ $user['registration_date'] }}
                </td>
                <td>
                    {{ $user['questions']}}
                </td>
                <td>
                    {{ $user['answers']}}
                </td>
            </tr>
        @endforeach

    </table>
@endsection