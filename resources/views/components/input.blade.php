@props(['label', 'name'])
<div class="mb-4">
    <label for="{{ $name }}" class="block text-sm font-medium mb-1">{{ $label }}</label>
    <input id="{{ $name }}" name="{{ $name }}"
        value="{{ $attributes->get('type') === 'password' ? '' : old($name) }}"
        {{ $attributes->merge(['class' => 'w-full border border-slate-300 rounded-lg px-3 py-2 bg-white']) }}>
    @error($name)
        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>
