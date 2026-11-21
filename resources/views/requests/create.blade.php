<x-layouts.app title="Request Item - Circlo">
    <a href="{{ route('explore.show', $listing) }}" class="text-sm text-slate-500 hover:text-slate-800">&larr; Back to
        item</a>
    <h1 class="text-2xl font-bold mt-2">Request Item</h1>
    <p class="text-slate-500 mb-6">Choose the period and send your request to the owner.</p>

    <div class="grid gap-6 md:grid-cols-3">
        <form method="POST" action="{{ route('requests.store', $listing) }}"
            class="bg-white rounded-xl shadow p-6 md:col-span-2">
            @csrf

            <div class="flex items-center gap-4 rounded-lg bg-slate-50 p-3 mb-6">
                @if ($listing->photos->first())
                    <img src="{{ route('photos.show', $listing->photos->first()->id) }}" alt="{{ $listing->item_name }}"
                        class="w-16 h-16 rounded-lg object-cover">
                @else
                    <div class="w-16 h-16 rounded-lg bg-slate-200"></div>
                @endif
                <div>
                    <p class="font-semibold">{{ $listing->item_name }}</p>
                    <p class="text-sm text-slate-500">
                        {{ $listing->category->category_name }} &middot; {{ $listing->listingType->type_name }}
                        &middot; owner {{ $listing->owner->name }}
                    </p>
                </div>
            </div>

            <div class="grid gap-4 md:grid-cols-2">
                <x-input label="Start date" name="start_date" type="date" :min="now()->toDateString()" />
                <x-input label="End date" name="end_date" type="date" :min="now()->toDateString()" />
            </div>

            <x-textarea label="Note to the owner (optional)" name="note" :rows="4" />

            <div class="flex gap-3">
                <x-button type="submit">Submit Request</x-button>
                <a href="{{ route('explore.show', $listing) }}"
                    class="px-4 py-2 border rounded-lg hover:bg-slate-50">Cancel</a>
            </div>
        </form>

        <div class="bg-white rounded-xl shadow p-6 h-fit">
            <h2 class="font-semibold mb-3">Request summary</h2>
            <div class="text-sm divide-y">
                <div class="flex justify-between py-2"><span class="text-slate-500">Price</span>
                    <span>{{ $listing->price_per_day > 0 ? 'Rp ' . number_format($listing->price_per_day, 0, ',', '.') . ' / day' : 'Free' }}</span>
                </div>
                <div class="flex justify-between py-2"><span class="text-slate-500">Duration</span><span
                        id="sum-days">-</span></div>
                <div class="flex justify-between py-2 font-semibold"><span>Estimated total</span><span
                        id="sum-total">-</span></div>
            </div>
            <p class="text-xs text-slate-500 mt-3">The owner decides whether to accept your request. You can cancel it
                while it is pending.</p>
        </div>
    </div>

    <script>
        (function() {
            var price = {{ (float) $listing->price_per_day }};
            var start = document.getElementById('start_date');
            var end = document.getElementById('end_date');
            var days = document.getElementById('sum-days');
            var total = document.getElementById('sum-total');

            function update() {
                if (start.value) {
                    end.min = start.value;
                }
                if (!start.value || !end.value || end.value < start.value) {
                    days.textContent = '-';
                    total.textContent = '-';
                    return;
                }
                var n = Math.round((new Date(end.value) - new Date(start.value)) / 86400000) + 1;
                days.textContent = n + (n === 1 ? ' day' : ' days');
                total.textContent = price > 0 ? 'Rp ' + (n * price).toLocaleString('id-ID') : 'Free';
            }

            start.addEventListener('change', update);
            end.addEventListener('change', update);
            update();
        })();
    </script>
</x-layouts.app>
