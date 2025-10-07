@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(attributeDefaults: ['class' => 'border-black focus:border-indigo-500 rounded-md shadow-sm border border-gray-300 rounded px-2 py-3 text-sm w-full custom-timepicker cursor-pointer bg-white']) }}>
