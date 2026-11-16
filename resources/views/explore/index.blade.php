<x-layouts.app title="Explore - Circlo">
    <h1 class="text-2xl font-bold">Explore</h1>
    <p class="text-slate-500 mb-4">{{ $listings->total() }} {{ Str::plural('item', $listings->total()) }} found</p>

    <form method="GET" action="{{ route('explore.index') }}" class="bg-white rounded-xl shadow p-4 mb-6">
        <div class="mb-4">
            <label for="q" class="block text-sm font-medium mb-1">Search</label>
            <input id="q" name="q" value="{{ request('q') }}" placeholder="Search items..."
                class="w-full border border-slate-300 rounded-lg px-3 py-2 bg-white">
        </div>

        <div class="grid gap-4 md:grid-cols-3">
            <x-select label="Category" name="category_id" :options="$categories" :selected="request('category_id')"
                placeholder="All categories" />
            <x-select label="Transaction type" name="listing_type_id" :options="$types" :selected="request('listing_type_id')"
                placeholder="All types" />
            <x-select label="Availability" name="availability" :options="['Available' => 'Available now', 'Booked' => 'Borrowed']" :selected="request('availability')" placeholder="Any" />
        </div>

        <div class="flex gap-3">
            <x-button type="submit">Apply filters</x-button>
            <a href="{{ route('explore.index') }}" class="px-4 py-2 border rounded-lg hover:bg-slate-50">Clear</a>
        </div>
    </form>

    @if ($listings->isEmpty())
        <div class="bg-white rounded-xl shadow p-8 text-center text-slate-500">
            @if ($hasFilters)
                No items found. Try a different keyword or reset the filters.
            @else
                No items are available yet.
            @endif
        </div>
    @else
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($listings as $listing)
                <x-listing-card :listing="$listing" />
            @endforeach
        </div>

        <div class="mt-6">{{ $listings->links() }}</div>
    @endif
</x-layouts.app>
