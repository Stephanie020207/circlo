<x-input label="Item name" name="item_name" :value="$listing?->item_name" />

<div class="grid gap-4 md:grid-cols-2">
    <x-select label="Category" name="category_id" :options="$categories" :selected="$listing?->category_id" />
    <x-select label="Condition" name="condition" :options="['New' => 'New', 'Like new' => 'Like new', 'Good' => 'Good', 'Fair' => 'Fair']" :selected="$listing?->condition" />
    <x-select label="Transaction type" name="listing_type_id" :options="$types" :selected="$listing?->listing_type_id" />
    <x-input label="Price per day (Rp, 0 for free sharing)" name="price_per_day" type="number" min="0"
        step="1" :value="$listing?->price_per_day" />
</div>

<x-input label="Pickup location" name="pickup_location" :value="$listing?->pickup_location" />
<x-textarea label="Description" name="description" :value="$listing?->description" />

<div class="mb-4">
    <label for="photos" class="block text-sm font-medium mb-1">
        {{ $listing ? 'Replace photos (optional)' : 'Photos' }}
    </label>
    <input id="photos" type="file" name="photos[]" multiple accept="image/png,image/jpeg"
        class="w-full border border-slate-300 rounded-lg px-3 py-2 bg-white">
    <p class="text-xs text-slate-500 mt-1">JPG or PNG, up to 5 MB each, up to 5 photos.</p>

    @foreach ($errors->get('photos') as $message)
        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
    @endforeach
    @foreach ($errors->get('photos.*') as $messages)
        @foreach ($messages as $message)
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
        @endforeach
    @endforeach
</div>
