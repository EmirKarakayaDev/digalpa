@props(['items' => []])

@if (count($items))
<nav aria-label="Breadcrumb" class="border-b border-gray-100 bg-gray-50">
    <div class="container-content py-3">
        <ol class="flex items-center gap-1.5 text-xs text-gray-500 flex-wrap">
            <li>
                <a href="{{ route('home') }}" class="hover:text-navy transition-colors">Ana Sayfa</a>
            </li>
            @foreach ($items as $label => $url)
            <li class="flex items-center gap-1.5">
                <span class="text-gray-300">/</span>
                @if ($url && !$loop->last)
                    <a href="{{ $url }}" class="hover:text-navy transition-colors">{{ $label }}</a>
                @else
                    <span class="text-navy font-medium">{{ $label }}</span>
                @endif
            </li>
            @endforeach
        </ol>
    </div>
</nav>
@endif
