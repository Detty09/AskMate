<!DOCTYPE html>
<html>
<head>
    <title>@yield('title', 'My App')</title>
</head>
<body>
<nav>
    <a href="/home">Home</a> |
    <a href="/about">About</a>
    <a href="/register">Register</a>
</nav>

<main>
    @yield('content')
</main>

<footer>
    <p>&copy; {{ date('Y') }} My App</p>
</footer>
</body>
</html>

