@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
    'class' =>
        'bg-neutral-800 text-neutral-200 border-neutral-400 focus:border-lime-500 focus:ring-indigo-500 rounded-md shadow-sm',
]) !!}>
