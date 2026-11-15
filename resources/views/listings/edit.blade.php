<x-layouts.app title="Edit Item - Circlo">
    <h1 class="text-2xl font-bold mb-6">Edit Item</h1>

    <form method="POST" action="{{ route('listings.update', $listing) }}" enctype="multipart/form-data"
        class="bg-white rounded-xl shadow p-6 max-w-3xl">
        @csrf
        @method('PUT')
        @include('listings._form', ['listing' => $listing])

        <div class="flex gap-3">
            <x-button type="submit">Save</x-button>
            <a href="{{ route('listings.show', $listing) }}"
                class="px-4 py-2 border rounded-lg hover:bg-slate-50">Cancel</a>
        </div>
    </form>
</x-layouts.app>
