<x-layouts.app title="Request Detail - Circlo">
    <a href="{{ route('transactions.index') }}" class="text-sm text-slate-500 hover:text-slate-800">&larr; Back to My
        Transactions</a>

    <div class="flex items-center gap-3 mt-2 mb-6">
        <h1 class="text-2xl font-bold">Request Detail</h1>
        <x-status-badge :status="$req->status" />
    </div>

    <div class="grid gap-6 md:grid-cols-2">
        <div class="bg-white rounded-xl shadow p-6 h-fit">
            <h2 class="font-semibold mb-3">Requester</h2>
            <div class="rounded-lg bg-slate-50 p-3 mb-6 text-sm">
                <p class="font-semibold">{{ $req->requester->name }}</p>
                <p class="text-slate-500">{{ $req->requester->email }}</p>
                @if ($req->requester->member_since)
                    <p class="text-slate-500">Member since
                        {{ \Illuminate\Support\Carbon::parse($req->requester->member_since)->format('M Y') }}</p>
                @endif
            </div>

            <h2 class="font-semibold mb-3">Item</h2>
            <div class="flex items-center gap-4">
                @if ($req->itemListing->photos->first())
                    <img src="{{ route('photos.show', $req->itemListing->photos->first()->id) }}"
                        alt="{{ $req->itemListing->item_name }}" class="w-20 h-20 rounded-lg object-cover">
                @else
                    <div class="w-20 h-20 rounded-lg bg-slate-200"></div>
                @endif
                <div class="text-sm">
                    <p class="font-semibold">{{ $req->itemListing->item_name }}</p>
                    <p class="text-slate-500">{{ $req->itemListing->category->category_name }} &middot;
                        {{ $req->itemListing->listingType->type_name }}</p>
                    <p class="text-slate-500">
                        {{ $req->itemListing->price_per_day > 0 ? 'Rp ' . number_format($req->itemListing->price_per_day, 0, ',', '.') . ' / day' : 'Free' }}
                    </p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow p-6 h-fit">
            <h2 class="font-semibold mb-3">Requested period</h2>
            <div class="text-sm divide-y mb-4">
                <div class="flex justify-between py-2"><span class="text-slate-500">Start
                        date</span><span>{{ $req->start_date->format('j M Y') }}</span></div>
                <div class="flex justify-between py-2"><span class="text-slate-500">End
                        date</span><span>{{ $req->end_date->format('j M Y') }}</span></div>
                <div class="flex justify-between py-2"><span
                        class="text-slate-500">Duration</span><span>{{ $req->days() }}
                        {{ Str::plural('day', $req->days()) }}</span></div>
                <div class="flex justify-between py-2 font-semibold"><span>Estimated total</span>
                    <span>{{ $req->totalPrice() > 0 ? 'Rp ' . number_format($req->totalPrice(), 0, ',', '.') : 'Free' }}</span>
                </div>
            </div>

            <h2 class="font-semibold mb-1">Note from the requester</h2>
            <p class="text-sm text-slate-700 mb-6 whitespace-pre-line">{{ $req->note ?: 'No note.' }}</p>

            @if ($req->status === 'Pending')
                <form method="POST" action="{{ route('requests.accept', $req) }}" class="mb-4">
                    @csrf
                    <x-button type="submit" class="w-full">Accept</x-button>
                </form>

                <form method="POST" action="{{ route('requests.reject', $req) }}"
                    onsubmit="return confirm('Reject this request?')">
                    @csrf
                    <x-textarea label="Reason for rejecting (optional)" name="rejection_reason" :rows="2" />
                    <button type="submit"
                        class="w-full rounded-lg px-4 py-2 bg-red-100 text-red-700 font-semibold hover:bg-red-200">Reject</button>
                </form>
            @elseif ($req->status === 'Rejected')
                <p class="text-sm text-slate-600">You rejected this request.
                    @if ($req->rejection_reason)
                        Reason: {{ $req->rejection_reason }}
                    @endif
                </p>
            @elseif ($req->status === 'Accepted')
                <p class="text-sm text-slate-600">You accepted this request. It is now an active transaction in
                    <a href="{{ route('transactions.index', ['tab' => 'active']) }}"
                        class="text-blue-600 hover:underline">My Transactions</a>.
                </p>
            @else
                <p class="text-sm text-slate-600">The requester cancelled this request.</p>
            @endif
        </div>
    </div>
</x-layouts.app>
