<nav class="bg-white shadow px-6 py-3 flex justify-between">
    <div class="font-semibold text-gray-700">
        E-Office
    </div>

    <div class="space-x-4">
        <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-green-600">Dashboard</a>
        <a href="{{ route('logout') }}"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
            class="text-red-500">Logout</a>
    </div>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
        @csrf
    </form>
</nav>
