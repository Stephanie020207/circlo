<x-layouts.app title="Home - Circlo">
    <div class="rounded-xl bg-blue-600 text-white p-6 mb-6">
        <h1 class="text-2xl font-bold">Hello, {{ auth()->user()->name }}</h1>
        <p class="opacity-90">Borrow it from your peers!</p>
    </div>

    <h2 class="font-bold mb-3">Recommended for you</h2>
    <p class="text-slate-500">Item listings will appear here once we build the listing pages.</p>
</x-layouts.app>
