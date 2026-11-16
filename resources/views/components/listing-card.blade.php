@props(['listing'])
<a href="{{ route('explore.show', $listing) }}"
    class="block bg-white rounded-xl shadow hover:shadow-md overflow-hidden transition">
    @if ($listing->photos->first())
        <img src="{{ route('photos.show', $listing->photos->first()->id) }}" alt="{{ $listing->item_name }}"
            class="w-full h-40 object-cover">
    @else
        <div class="h-40 bg-slate-200"></div>
    @endif

    <div class="p-4">
        <div class="flex items-start justify-between gap-2">
            <h3 class="font-semibold">{{ $listing->item_name }}</h3>
            @if ($listing->availability === 'Booked')
                <span class="text-xs rounded-full bg-amber-100 text-amber-800 px-2 py-0.5 shrink-0">Borrowed</span>
            @else
                <span class="text-xs rounded-full bg-green-100 text-green-800 px-2 py-0.5 shrink-0">Available</span>
            @endif
        </div>
        <p class="text-sm text-slate-500">{{ $listing->category->category_name }} &middot;
            {{ $listing->listingType->type_name }}</p>
        <p class="text-blue-600 font-semibold mt-1">
            {{ $listing->price_per_day > 0 ? 'Rp ' . number_format($listing->price_per_day, 0, ',', '.') . ' / day' : 'Free' }}
        </p>
        <p class="text-xs text-slate-500 mt-1">by {{ $listing->owner->name }}</p>
    </div>
</a>
