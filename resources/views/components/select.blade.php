@props(['label', 'name', 'options', 'selected' => null, 'placeholder' => 'Select...'])
<div class="mb-4">
    <label for="{{ $name }}" class="block text-sm font-medium mb-1">{{ $label }}</label>
    <select id="{{ $name }}" name="{{ $name }}"
        {{ $attributes->merge(['class' => 'w-full border border-slate-300 rounded-lg px-3 py-2 bg-white']) }}>
        <option value="">{{ $placeholder }}</option>
        @foreach ($options as $optionValue => $text)
            <option value="{{ $optionValue }}" @selected(old($name, $selected) == $optionValue)>{{ $text }}</option>
        @endforeach
    </select>
    @error($name)
        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>
