<nav style="background: #555">
    <div class="d-flex justify-content-between align-items-center px-3 py-2">
        <h2 class="font-bold text-white text-xl">User</h2>
        <div>
        @if (Auth::check())
            <a href="/logout" class="text-white">Logout</a>
            @else
            <a href="/login" class="text-white">Login</a>
            <a href="/register" class="text-white ml-3">Register</a>

        @endif
    </div>
    </div>
</nav>
