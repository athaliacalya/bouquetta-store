{{-- resources/views/components/logo-flower.blade.php --}}
@props(['color' => 'dark'])

<svg {{ $attributes->merge(['viewBox' => '0 0 32 32', 'fill' => 'none', 'xmlns' => 'http://www.w3.org/2000/svg']) }}>
    @if($color === 'light')
        <circle cx="16" cy="16" r="6" fill="#FAD5DC"/>
        <circle cx="16" cy="8" r="5" fill="#F4B6C2" opacity="0.8"/>
        <circle cx="22" cy="12" r="5" fill="#F8C6A8" opacity="0.8"/>
        <circle cx="22" cy="20" r="5" fill="#FAD5DC" opacity="0.8"/>
        <circle cx="16" cy="24" r="5" fill="#F4B6C2" opacity="0.8"/>
        <circle cx="10" cy="20" r="5" fill="#F8C6A8" opacity="0.8"/>
        <circle cx="10" cy="12" r="5" fill="#FAD5DC" opacity="0.8"/>
        <circle cx="16" cy="16" r="3" fill="#F5EBDD"/>
    @else
        <circle cx="16" cy="16" r="6" fill="#F4B6C2"/>
        <circle cx="16" cy="8" r="5" fill="#D85B34" opacity="0.8"/>
        <circle cx="22" cy="12" r="5" fill="#F8C6A8" opacity="0.8"/>
        <circle cx="22" cy="20" r="5" fill="#F4B6C2" opacity="0.8"/>
        <circle cx="16" cy="24" r="5" fill="#D85B34" opacity="0.8"/>
        <circle cx="10" cy="20" r="5" fill="#F8C6A8" opacity="0.8"/>
        <circle cx="10" cy="12" r="5" fill="#F4B6C2" opacity="0.8"/>
        <circle cx="16" cy="16" r="3" fill="#FDF6EE"/>
    @endif
</svg>
