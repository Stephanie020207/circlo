<x-layouts.app title="My Transactions - Circlo">
    <h1 class="text-2xl font-bold">My Transactions</h1>
    <p class="text-slate-500 mb-4">Track your requests and your borrowing and lending.</p>

    @if ($incoming->isNotEmpty())
        <div class="rounded-xl border border-amber-200 bg-amber-50 p-4 mb-6">
            <p class="font-semibold mb-2">Requests waiting for your decision ({{ $incoming->count() }})</p>
            @foreach ($incoming as $in)
                <a href="{{ route('requests.show', $in) }}"
                    class="flex items-center justify-between py-1 text-sm hover:underline">
                    <span>{{ $in->requester->name }} wants {{ $in->itemListing->item_name }}
                        ({{ $in->start_date->format('j M') }} - {{ $in->end_date->format('j M Y') }})
                    </span>
                    <span class="text-blue-600">Review</span>
                </a>
            @endforeach
        </div>
    @endif

    <div class="flex gap-2 mb-4 border-b">
        @foreach (['pending' => 'Pending', 'active' => 'Active', 'completed' => 'Completed'] as $key => $label)
            <a href="{{ route('transactions.index', ['tab' => $key]) }}"
                class="px-4 py-2 text-sm font-medium -mb-px border-b-2 {{ $tab === $key ? 'border-blue-600 text-blue-600' : 'border-transparent text-slate-500 hover:text-slate-800' }}">
                {{ $label }} ({{ $counts[$key] }})
            </a>
        @endforeach
    </div>

    @if ($tab === 'pending')
        @forelse ($requests as $r)
            <div class="bg-white rounded-xl shadow p-4 mb-3 flex items-center gap-4">
                @if ($r->itemListing->photos->first())
                    <img src="{{ route('photos.show', $r->itemListing->photos->first()->id) }}"
                        alt="{{ $r->itemListing->item_name }}" class="w-16 h-16 rounded-lg object-cover">
                @else
                    <div class="w-16 h-16 rounded-lg bg-slate-200"></div>
                @endif

                <div class="flex-1">
                    <a href="{{ route('explore.show', $r->itemListing) }}"
                        class="font-semibold hover:underline">{{ $r->itemListing->item_name }}</a>
                    <p class="text-sm text-slate-500">
                        Owner {{ $r->itemListing->owner->name }} &middot;
                        {{ $r->start_date->format('j M Y') }} - {{ $r->end_date->format('j M Y') }}
                        ({{ $r->days() }} {{ Str::plural('day', $r->days()) }})
                    </p>
                    @if ($r->status === 'Rejected' && $r->rejection_reason)
                        <p class="text-sm text-red-600">Reason: {{ $r->rejection_reason }}</p>
                    @endif
                </div>

                <x-status-badge :status="$r->status" />

                @if ($r->status === 'Pending')
                    <form method="POST" action="{{ route('requests.cancel', $r) }}"
                        onsubmit="return confirm('Cancel this request?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="text-sm rounded-lg px-3 py-1 bg-red-100 text-red-700 hover:bg-red-200">Cancel
                            Request</button>
                    </form>
                @endif
            </div>
        @empty
            <div class="bg-white rounded-xl shadow p-8 text-center text-slate-500">
                You have no pending requests. Find an item in <a href="{{ route('explore.index') }}"
                    class="text-blue-600 hover:underline">Explore</a> and press "Borrow / Rent".
            </div>
        @endforelse
    @else
        @forelse ($transactions as $t)
            @php
                $sr = $t->sharingRequest;
                $listing = $sr->itemListing;
                $isBorrower = (int) $sr->requester_id === (int) auth()->id();
            @endphp
            <div class="bg-white rounded-xl shadow p-4 mb-3 flex items-center gap-4">
                @if ($listing->photos->first())
                    <img src="{{ route('photos.show', $listing->photos->first()->id) }}"
                        alt="{{ $listing->item_name }}" class="w-16 h-16 rounded-lg object-cover">
                @else
                    <div class="w-16 h-16 rounded-lg bg-slate-200"></div>
                @endif

                <div class="flex-1">
                    <a href="{{ route('explore.show', $listing) }}"
                        class="font-semibold hover:underline">{{ $listing->item_name }}</a>
                    <p class="text-sm text-slate-500">
                        {{ $isBorrower ? 'You borrow from ' . $listing->owner->name : 'You lend to ' . $sr->requester->name }}
                        &middot; {{ $t->start_date->format('j M Y') }} - {{ $t->end_date->format('j M Y') }}
                    </p>
                    <p class="text-sm text-slate-500">
                        Total: {{ $t->total_price > 0 ? 'Rp ' . number_format($t->total_price, 0, ',', '.') : 'Free' }}
                        @if ($t->status === 'Completed' && $t->completed_at)
                            &middot; completed {{ $t->completed_at->format('j M Y') }}
                        @endif
                    </p>
                </div>

                <x-status-badge :status="$t->status" />
            </div>
        @empty
            <div class="bg-white rounded-xl shadow p-8 text-center text-slate-500">
                There are no {{ $tab }} transactions yet.
            </div>
        @endforelse
    @endif
</x-layouts.app>
