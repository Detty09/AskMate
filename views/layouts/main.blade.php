<!DOCTYPE html>
<html>
<head>
    <title>@yield('title', 'My App')</title>
</head>
<body>
<nav>
    <a href="/home">Home</a> |
    <a href="/add-question">Add Question</a>
</nav>

<main>
    @yield('content')
</main>

<footer>
    <p>&copy; {{ date('Y') }} My App</p>
</footer>
</body>
</html>

