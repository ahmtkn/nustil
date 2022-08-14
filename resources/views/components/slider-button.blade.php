<a class="btn btn-{{ $color }}" href="{{ $href }}" target="{{ $target }}">
    @if($icon)
        <i icon-name="{{ $icon }}"></i>
    @endif
    <span>{{ $text }}</span>
</a>
