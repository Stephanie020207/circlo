<x-layouts.app title="Item Preview - Circlo">
    <a href="{{ route('listings.index') }}" class="text-sm text-slate-500 hover:text-slate-800">&larr; Back to My
        Items</a>

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
            <h1 class="text-2xl font-bold">{{ $listing->item_name }}</h1>
            <p class="text-blue-600 font-semibold mb-4">
                Rp {{ number_format($listing->price_per_day, 0, ',', '.') }} / day
            </p>

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
                <div class="flex justify-between py-2"><span class="text-slate-500">Listed
                        on</span><span>{{ \Illuminate\Support\Carbon::parse($listing->listed_date)->format('j M Y') }}</span>
                </div>
            </div>

            <h2 class="font-semibold mb-1">Description</h2>
            <p class="text-sm text-slate-700 mb-6 whitespace-pre-line">{{ $listing->description }}</p>

            <a href="{{ route('listings.edit', $listing) }}"><x-button>Edit listing</x-button></a>
        </div>
    </div>
</x-layouts.app>
