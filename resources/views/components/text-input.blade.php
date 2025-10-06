@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(attributeDefaults: ['class' => 'border-black focus:border-indigo-500 rounded-md shadow-sm p-0']) }}>
