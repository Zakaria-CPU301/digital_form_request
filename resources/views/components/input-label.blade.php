@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-extrabold text-md text-gray-700']) }}>
    {{ $value ?? $slot }}
</label>
