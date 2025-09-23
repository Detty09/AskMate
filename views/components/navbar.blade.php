<nav class="border-gray-200 bg-gray-900">
    <div class="flex flex-wrap justify-between items-center mx-auto max-w-screen-xl p-4">
        <a href="/" class="flex items-center space-x-3 rtl:space-x-reverse">
            <img src="/images/logo.png" class="h-8" alt="Codecool Logo"/>
            <span class="self-center text-2xl font-semibold whitespace-nowrap text-white">Attendance->No</span>
        </a>
        @if(\App\Http\SuperGlobalManager::hasSession('user_id'))
            <div class="flex items-center space-x-6 rtl:space-x-reverse">
                <a href="/logout" class="text-sm text-blue-500 hover:underline">Logout</a>
            </div>
        @else
            <div class="flex justify-end space-x-6">
                <div class="flex items-center space-x-6 rtl:space-x-reverse">
                    <a href="/login" class="text-sm  text-blue-500 hover:underline">Login</a>
                </div>
                <div class="flex items-center space-x-6 rtl:space-x-reverse">
                    <a href="/register" class="text-sm  text-blue-500 hover:underline">Register</a>
                </div>
            </div>
        @endif
    </div>
</nav>
<nav class="bg-gray-700">
    <div class="max-w-screen-xl px-4 py-3 mx-auto">
        <div class="flex items-center">
            <ul class="flex flex-row font-medium mt-0 space-x-8 rtl:space-x-reverse text-sm">
                <li>
                    <a href="/" class="text-white hover:underline" aria-current="page">Home</a>
                </li>
                <li>
                    <a href="/add-question" class="text-white hover:underline">Add Question</a>
                </li>
                <li>
                    <a href="/my-questions" class="text-white hover:underline">My Questions</a>
                </li>
                <li>
                    <a href="/users" class="text-white hover:underline">List Users</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
