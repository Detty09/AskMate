<!DOCTYPE html>
<html>
<head>
    <title>@yield('title', 'My App')</title>
</head>
<body>
<nav>
    <a href="/home">Home</a> |
    <a href="/add-question">Add Question</a>

    @if(isset($_SESSION['user_id']))
        <a href="/logout" methods="POST">Logout</a>
    @else
        <a href="/login">Login</a>
        <a href="/register">Register</a>
    @endif
</nav>

<main>
    @yield('content')
</main>

<footer>
    <p>&copy; {{ date('Y') }} My App</p>
</footer>
</body>
</html>

