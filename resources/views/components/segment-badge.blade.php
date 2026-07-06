@props(['segment', 'size' => 'sm'])

@if ($segment)
<span class="segment-badge segment-badge--{{ $segment->color_key }}">
    {{ $segment->name }}
</span>
@endif
