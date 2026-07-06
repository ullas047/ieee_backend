<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<script src="{{ asset('js/app.js') }}" defer></script>
</head>

<body class="bg-gray-100">

    <div class="flex h-screen overflow-hidden">

        <!-- Sidebar -->
        <aside class="w-64 bg-slate-900 text-white flex flex-col">

            <!-- Logo -->
            <div class="h-16 flex items-center px-6 border-b border-slate-700">
                <h1 class="text-xl font-bold">
                    Admin Panel
                </h1>
            </div>

            <!-- Menu -->
            <nav class="flex-1 py-4">

                <a href="{{ route('dashboard') }}"
                    class="block px-6 py-3 hover:bg-slate-800 {{ request()->routeIs('dashboard') ? 'bg-slate-800 border-r-4 border-blue-500' : '' }}">
                    Dashboard
                </a>

                <a href="{{ route('events.index') }}"
                    class="block px-6 py-3 hover:bg-slate-800 {{ request()->routeIs('events.*') ? 'bg-slate-800 border-r-4 border-blue-500' : '' }}">
                    Events
                </a>
                <a href="{{ route('committees.index') }}"
                    class="block px-6 py-3 hover:bg-slate-800 {{ request()->routeIs('committees.*') ? 'bg-slate-800 border-r-4 border-blue-500' : '' }}">
                    Committees
                </a>

            </nav>

            <!-- Bottom -->
            <div class="border-t border-slate-700 p-4 text-sm text-gray-400">
                ©developed by Ullas {{ date('Y') }}
            </div>

        </aside>

        <!-- Content Area -->
        <div class="flex-1 flex flex-col">

            <!-- Topbar -->
            <header class="bg-white h-16 shadow flex items-center justify-between px-6">

                <div>
                    <h2 class="text-lg font-semibold">
                        @yield('page-title', 'Dashboard')
                    </h2>
                </div>

                <div class="flex items-center gap-4">

                    <div class="text-right">
                        <div class="font-semibold">
                            {{ auth()->user()->name }}
                        </div>

                        <div class="text-xs text-gray-500">
                            {{ auth()->user()->email }}
                        </div>
                    </div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <button class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">
                            Logout
                        </button>
                    </form>

                </div>

            </header>

            <!-- Main Content -->
            <main class="flex-1 overflow-y-auto p-6">

                @yield('content')

            </main>

        </div>

    </div>
    <div id="toast" class="fixed top-5 right-5 hidden px-4 py-3 rounded shadow text-white z-50">
    </div>

    <script>
        function showToast(message, type = 'success') {
            const toast = document.getElementById('toast');

            toast.classList.remove('hidden');

            toast.innerText = message;

            if (type === 'success') {
                toast.className = 'fixed top-5 right-5 px-4 py-3 rounded shadow text-white bg-green-600 z-50';
            } else if (type === 'error') {
                toast.className = 'fixed top-5 right-5 px-4 py-3 rounded shadow text-white bg-red-600 z-50';
            }

            setTimeout(() => {
                toast.classList.add('hidden');
            }, 3000);
        }
    </script>

</body>

</html>