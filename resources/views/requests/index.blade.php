<x-layouts.app title="Incoming Requests - Circlo">
    <h1 class="text-2xl font-bold">Incoming Requests</h1>
    <p class="text-slate-500 mb-4">Requests from other students for the items you offer. Accept or reject them here.</p>

    @forelse ($requests as $r)
        <div class="bg-white rounded-xl shadow p-4 mb-3 flex items-center gap-4">
            @if ($r->itemListing->photos->first())
                <img src="{{ route('photos.show', $r->itemListing->photos->first()->id) }}"
                    alt="{{ $r->itemListing->item_name }}" class="w-16 h-16 rounded-lg object-cover">
            @else
                <div class="w-16 h-16 rounded-lg bg-slate-200"></div>
            @endif

            <div class="flex-1">
                <p class="font-semibold">{{ $r->itemListing->item_name }}</p>
                <p class="text-sm text-slate-500">
                    From {{ $r->requester->name }} &middot;
                    {{ $r->start_date->format('j M Y') }} - {{ $r->end_date->format('j M Y') }}
                    ({{ $r->days() }} {{ Str::plural('day', $r->days()) }})
                </p>
            </div>

            <x-status-badge :status="$r->status" />

            <a href="{{ route('requests.show', $r) }}"
                class="text-sm rounded-lg px-3 py-1 {{ $r->status === 'Pending' ? 'bg-blue-600 text-white hover:bg-blue-700' : 'border hover:bg-slate-50' }}">
                {{ $r->status === 'Pending' ? 'Review' : 'View' }}
            </a>
        </div>
    @empty
        <div class="bg-white rounded-xl shadow p-8 text-center text-slate-500">
            No requests yet. They appear here when other students request your items.
        </div>
    @endforelse
</x-layouts.app>
