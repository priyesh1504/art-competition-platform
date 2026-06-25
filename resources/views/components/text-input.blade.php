@props(['disabled' => false])

<input
    {{ $disabled ? 'disabled' : '' }}
    {!! $attributes->merge([
        'class' => '
            block w-full rounded-lg
            border border-gray-300
            bg-white text-gray-900
            placeholder-gray-400
            focus:border-primary
            focus:ring focus:ring-primary/30
            shadow-none
        '
    ]) !!}
>
