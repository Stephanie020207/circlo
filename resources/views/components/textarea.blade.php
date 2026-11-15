@props(['label', 'name', 'value' => null, 'rows' => 4])
<div class="mb-4">
    <label for="{{ $name }}" class="block text-sm font-medium mb-1">{{ $label }}</label>
    <textarea id="{{ $name }}" name="{{ $name }}" rows="{{ $rows }}"
        {{ $attributes->merge(['class' => 'w-full border border-slate-300 rounded-lg px-3 py-2 bg-white']) }}>{{ old($name, $value) }}</textarea>
    @error($name)
        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>
