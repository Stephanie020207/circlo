<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Circlo' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-100 text-slate-900">
    <div class="flex min-h-screen">
        <aside class="w-60 bg-slate-900 text-white flex flex-col p-4">
            <div class="text-2xl font-bold mb-8">CIRCLO</div>
            @php
                $links = [
                    'Home' => '/home',
                    'Explore' => '/explore',
                    'My Transactions' => '/transactions',
                    'My Items' => '/my-items',
                ];
            @endphp
            <nav class="flex flex-col gap-1">
                @foreach ($links as $label => $path)
                    <a href="{{ url($path) }}"
                        class="px-3 py-2 rounded-lg {{ request()->is(ltrim($path, '/') . '*') ? 'bg-blue-600' : 'hover:bg-slate-800' }}">
                        {{ $label }}
                    </a>
                @endforeach
            </nav>
            <div class="mt-auto text-sm text-slate-300">
                {{ auth()->user()->name }}
                <form method="POST" action="{{ route('logout') }}" class="mt-2">
                    @csrf
                    <button type="submit" class="text-slate-400 hover:text-white">Log out</button>
                </form>
            </div>
        </aside>
        <main class="flex-1 p-8">
            <x-alert />
            {{ $slot }}
        </main>
    </div>
</body>

</html>
