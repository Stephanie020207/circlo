<x-layouts.app title="Home - Circlo">
    <div class="rounded-xl bg-blue-600 text-white p-6 mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold">Hello, {{ auth()->user()->name }}</h1>
            <p class="opacity-90">Need something? Borrow it from your peers!</p>
        </div>
        <a href="{{ route('explore.index') }}" class="bg-white text-blue-600 font-semibold px-4 py-2 rounded-lg">Explore
            now</a>
    </div>

    <h2 class="font-bold mb-3">Recommended for you</h2>

    @if ($listings->isEmpty())
        <p class="text-slate-500">No items yet. Add one from My Items to get things started.</p>
    @else
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($listings as $listing)
                <x-listing-card :listing="$listing" />
            @endforeach
        </div>
    @endif
</x-layouts.app>
