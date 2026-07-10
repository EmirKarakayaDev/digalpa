<x-layouts.app :title="$node->label . ' — Ürün Bulucu — Digalpa'">

    @php
        $bcItems = ['Ürün Bulucu' => route('finder.index')];
        foreach ($breadcrumb as $i => $crumb) {
            $bcItems[$crumb->label] = ($i < count($breadcrumb) - 1)
                ? route('finder.step', $crumb->slug)
                : null;
        }
    @endphp
    <x-breadcrumb :items="$bcItems" />

    <div class="container-content py-16">

        {{-- Progress Bar --}}
        @php
            $currentStep = min($node->depth + 1, 3);
            $steps = ['Segment', 'Uygulama', 'Detay'];
        @endphp
        <div class="max-w-xs mx-auto mb-12">
            <div class="grid relative" style="grid-template-columns: repeat({{ count($steps) }}, 1fr);">
                {{-- Bağlantı çizgileri — circle'ların ortasından geçen ayrı, mutlak konumlu katman
                     (circle ile aynı satırda olsaydı genişliğin çoğunu yiyip alttaki etiketi
                     circle'ın değil, "circle+çizgi" satırının ortasına hizalardı) --}}
                @for ($i = 0; $i < count($steps) - 1; $i++)
                <div class="absolute top-4 h-px {{ ($i + 1) < $currentStep ? 'bg-navy' : 'bg-gray-200' }}"
                     style="left: {{ (100 / count($steps)) * ($i + 0.5) }}%; width: {{ 100 / count($steps) }}%;"></div>
                @endfor

                @foreach ($steps as $i => $label)
                <div class="flex flex-col items-center relative z-10">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-semibold flex-shrink-0
                                {{ ($i + 1) < $currentStep ? 'bg-navy text-white' : (($i + 1) === $currentStep ? 'bg-navy text-white ring-4 ring-navy/20' : 'bg-gray-100 text-gray-400') }}">
                        @if (($i + 1) < $currentStep)
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                        @else
                            {{ $i + 1 }}
                        @endif
                    </div>
                    <div class="text-xs mt-1.5 {{ ($i + 1) <= $currentStep ? 'font-medium text-navy' : 'text-gray-400' }}">
                        {{ $label }}
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="max-w-2xl mx-auto text-center mb-10">
            <div class="label-caps mb-2">{{ $currentStep }}. Adım</div>
            <h1 class="text-3xl mb-3">{{ $node->label }}</h1>
            @if ($node->description)
            <p class="text-gray-600">{{ $node->description }}</p>
            @endif
        </div>

        <div class="max-w-3xl mx-auto grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach ($children as $child)
            <a href="{{ route('finder.step', $child->slug) }}"
               class="card p-6 group block text-center">
                <h3 class="font-medium transition-colors" style="color: var(--color-navy);">
                    {{ $child->label }}
                </h3>
                @if ($child->description)
                <p class="text-xs text-gray-500 mt-2 leading-relaxed">{{ $child->description }}</p>
                @endif
                <div class="mt-4 text-xs font-medium" style="color: var(--color-navy-40);">
                    {{ $child->isLeaf() ? 'Ürünleri Gör →' : 'Devam Et →' }}
                </div>
            </a>
            @endforeach
        </div>

        {{-- Geri butonu --}}
        <div class="text-center mt-10">
            @if (count($breadcrumb) > 1)
            <a href="{{ route('finder.step', $breadcrumb[count($breadcrumb) - 2]->slug) }}" class="btn btn-ghost text-sm">
                ← Geri
            </a>
            @else
            <a href="{{ route('finder.index') }}" class="btn btn-ghost text-sm">
                ← Geri
            </a>
            @endif
        </div>

    </div>

</x-layouts.app>
