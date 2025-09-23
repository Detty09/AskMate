@extends('layouts.main')

@section('title', 'Login')

@section('content')
    <div class="flex flex-col mx-auto p-6 mt-6 border-4 rounded-lg border-gray-900">
        <x-header>Welcome Back!</x-header>
        <form action="/login" method="POST" class="max-w-md mx-auto mt-10">
            <div class="relative z-0 w-full mb-5 group">
                <input type="email" name="email" id="email"
                       class="block py-2.5 px-0 w-full text-sm bg-transparent border-0 border-b-2 border-gray-300 appearance-none text-white border-gray-600 focus:border-blue-500 focus:outline-none focus:ring-0 peer"
                       placeholder=" " required/>
                <label for="email"
                       class="peer-focus:font-medium absolute text-sm text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-95 peer-focus:-translate-y-6">Email
                    Address</label>
            </div>
            <div class="relative z-0 w-full mb-5 group">
                <input type="password" name="password" id="password"
                       class="block py-2.5 px-0 w-full text-sm bg-transparent border-0 border-b-2 border-gray-300 appearance-none text-white border-gray-600 focus:border-blue-500 focus:outline-none focus:ring-0 peer"
                       placeholder=" " required/>
                <label for="password"
                       class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-500 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-95 peer-focus:-translate-y-6">Password</label>
            </div>

            @if(isset($error))
                <div>
                    <x-error>{{$error}}</x-error>
                </div>
            @endif

            <div class="flex justify-center">
                <x-submit-button>Login</x-submit-button>
            </div>
        </form>
    </div>
@endsection