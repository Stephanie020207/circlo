<x-layouts.app title="{{ $listing->item_name }} - Circlo">
    <a href="{{ route('explore.index') }}" class="text-sm text-slate-500 hover:text-slate-800">&larr; Back to Explore</a>

    <div class="mt-4 grid gap-6 md:grid-cols-2">
        <div>
            @forelse ($listing->photos as $photo)
                <img src="{{ route('photos.show', $photo->id) }}" alt="{{ $listing->item_name }}"
                    class="rounded-xl w-full mb-3 object-cover">
            @empty
                <div class="bg-slate-200 rounded-xl h-64 flex items-center justify-center text-slate-500">No photo</div>
            @endforelse
        </div>

        <div class="bg-white rounded-xl shadow p-6 h-fit">
            <div class="flex items-start justify-between gap-3">
                <h1 class="text-2xl font-bold">{{ $listing->item_name }}</h1>
                @if ($listing->availability === 'Booked')
                    <span class="text-xs rounded-full bg-amber-100 text-amber-800 px-3 py-1">Borrowed</span>
                @else
                    <span class="text-xs rounded-full bg-green-100 text-green-800 px-3 py-1">Available</span>
                @endif
            </div>

            <p class="text-blue-600 font-semibold mb-4">
                {{ $listing->price_per_day > 0 ? 'Rp ' . number_format($listing->price_per_day, 0, ',', '.') . ' / day' : 'Free' }}
            </p>

            <div class="rounded-lg bg-slate-50 p-3 mb-4 text-sm">
                <span class="text-slate-500">Owner:</span>
                <span class="font-semibold">{{ $listing->owner->name }}</span>
                <span class="text-slate-500">&middot; member since
                    {{ \Illuminate\Support\Carbon::parse($listing->owner->member_since)->format('M Y') }}</span>
            </div>

            <div class="text-sm divide-y mb-4">
                <div class="flex justify-between py-2"><span
                        class="text-slate-500">Category</span><span>{{ $listing->category->category_name }}</span></div>
                <div class="flex justify-between py-2"><span
                        class="text-slate-500">Condition</span><span>{{ $listing->condition }}</span></div>
                <div class="flex justify-between py-2"><span
                        class="text-slate-500">Transaction</span><span>{{ $listing->listingType->type_name }}</span>
                </div>
                <div class="flex justify-between py-2"><span
                        class="text-slate-500">Pickup</span><span>{{ $listing->pickup_location }}</span></div>
            </div>

            <h2 class="font-semibold mb-1">Description</h2>
            <p class="text-sm text-slate-700 mb-6 whitespace-pre-line">{{ $listing->description }}</p>

            @if ((int) $listing->owner_id === (int) auth()->id())
                <p class="text-sm text-slate-500 mb-2">This is your own listing.</p>
                <a href="{{ route('listings.edit', $listing) }}"><x-button>Edit listing</x-button></a>
            @elseif ($listing->availability === 'Booked')
                <button disabled
                    class="w-full bg-slate-300 text-slate-600 font-semibold px-4 py-2 rounded-lg cursor-not-allowed">
                    Currently borrowed
                </button>
            @else
                {{-- Wired to the request form (UI-11) in the next feature --}}
                <a href="{{ route('requests.create', $listing) }}"><x-button class="w-full">Borrow /
                        Rent</x-button></a>
            @endif
        </div>
    </div>
</x-layouts.app>
