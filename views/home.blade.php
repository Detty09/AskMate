
@extends('layouts.main')

@section('title', 'Home Page')

@section('content')
    <div class="flex flex-col items-center mt-6 space-y-6">
        <x-header>Hello {{ $name }}</x-header>

    </div>
@endsection