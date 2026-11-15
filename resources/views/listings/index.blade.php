<x-layouts.app title="My Items - Circlo">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold">My Items</h1>
            <p class="text-slate-500">{{ $listings->count() }} {{ Str::plural('listing', $listings->count()) }}</p>
        </div>
        <a href="{{ route('listings.create') }}"><x-button>+ Add Item</x-button></a>
    </div>

    @forelse ($listings as $listing)
        <div class="bg-white rounded-xl shadow p-4 mb-3 flex items-center gap-4">
            @if ($listing->photos->first())
                <img src="{{ route('photos.show', $listing->photos->first()->id) }}" alt="{{ $listing->item_name }}"
                    class="w-16 h-16 rounded-lg object-cover">
            @else
                <div class="w-16 h-16 rounded-lg bg-slate-200"></div>
            @endif

            <div class="flex-1">
                <a href="{{ route('listings.show', $listing) }}"
                    class="font-semibold hover:underline">{{ $listing->item_name }}</a>
                <p class="text-sm text-slate-500">
                    {{ $listing->category->category_name }} &middot; {{ $listing->listingType->type_name }}
                    &middot; Rp {{ number_format($listing->price_per_day, 0, ',', '.') }}/day
                </p>
            </div>

            @if ($listing->availability === 'Booked')
                <span class="text-xs rounded-full bg-amber-100 text-amber-800 px-3 py-1">Borrowed</span>
            @else
                <span class="text-xs rounded-full bg-green-100 text-green-800 px-3 py-1">Published</span>
            @endif

            <a href="{{ route('listings.edit', $listing) }}"
                class="text-sm border rounded-lg px-3 py-1 hover:bg-slate-50">Edit</a>

            <form method="POST" action="{{ route('listings.destroy', $listing) }}"
                onsubmit="return confirm('Remove this listing?')">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="text-sm rounded-lg px-3 py-1 bg-red-100 text-red-700 hover:bg-red-200">Remove</button>
            </form>
        </div>
    @empty
        <div class="bg-white rounded-xl shadow p-8 text-center text-slate-500">
            You have no listings yet. Press "Add Item" to create your first one.
        </div>
    @endforelse
</x-layouts.app>
