<x-layouts.app title="Add New Item - Circlo">
    <h1 class="text-2xl font-bold mb-6">Add New Item</h1>

    <form method="POST" action="{{ route('listings.store') }}" enctype="multipart/form-data"
        class="bg-white rounded-xl shadow p-6 max-w-3xl">
        @csrf
        @include('listings._form', ['listing' => null])

        <div class="flex gap-3">
            <x-button type="submit">Save &amp; Preview</x-button>
            <a href="{{ route('listings.index') }}" class="px-4 py-2 border rounded-lg hover:bg-slate-50">Cancel</a>
        </div>
    </form>
</x-layouts.app>
