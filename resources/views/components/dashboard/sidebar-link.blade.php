@props(['active','indicated'])

@php
    $indicated = $indicated ?? false;
        $classes = ($active ?? false)
                    ? 'nav-link link-active'
                    : 'nav-link';
        $classes .= $indicated ? ' link-indicated' : '';
@endphp
<li>
    <a {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
</li>
