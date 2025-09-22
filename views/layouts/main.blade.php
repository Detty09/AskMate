<!DOCTYPE html>
<html>
<head>
    <title>@yield('title', 'My App')</title>
</head>
<body>
<nav>
    <a href="/">Home</a> |

    @if(\App\Http\SuperGlobalManager::hasSession('user_id'))
        <a href="/add-question">Add Question</a>
        <a href="/my-questions">My Questions</a>
        <a href="/users">List Users</a>
        <a href="/logout">Logout</a>
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

