<!DOCTYPE html>
<html>
<head>
    <title>@yield('title', 'My App')</title>
    <style>
        input:-webkit-autofill {
            caret-color: white;
            box-shadow: inset 0 0 0 1000px transparent;
            -webkit-text-fill-color: #fff;
            transition: background-color 5000s ease-in-out 0s;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col bg-white">
<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
<x-navbar></x-navbar>

<main class="flex-1 flex justify-center items-start">
    @yield('content')
</main>

<footer class="flex justify-end mr-6">
    <p class="text-white">&copy; {{ date('Y') }} My App</p>
</footer>
</body>
</html>

