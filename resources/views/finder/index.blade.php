<x-layouts.app title="Ürün Bulucu — Digalpa"
               description="Uygulama alanınıza göre doğru ürünü bulun.">

    <x-breadcrumb :items="['Ürün Bulucu' => null]" />

    <div class="container-content py-16">

        {{-- Progress Bar --}}
        {{-- ?segment= ile gelindiyse Segment adımı zaten tamamlanmış sayılır (Brief §08 akış kuralı) --}}
        @php $currentStep = $activeSegment ? 2 : 1; $steps = ['Segment', 'Uygulama', 'Detay']; @endphp
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
                                {{ ($i + 1) <= $currentStep ? 'bg-navy text-white' : 'bg-gray-100 text-gray-400' }}">
                        {{ $i + 1 }}
                    </div>
                    <div class="text-xs mt-1.5 {{ ($i + 1) <= $currentStep ? 'font-medium text-navy' : 'text-gray-400' }}">
                        {{ $label }}
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="max-w-2xl mx-auto text-center mb-10">
            @if ($activeSegment)
            <div class="mb-3 flex justify-center">
                <x-segment-badge :segment="$activeSegment" />
            </div>
            <h1 class="text-4xl mb-4">{{ $activeSegment->name }} İçin Uygulama Alanını Seçin</h1>
            <p class="text-gray-600 leading-relaxed">
                Ürününüzün kullanılacağı alanı seçerek devam edin.
                <a href="{{ route('finder.index') }}" class="underline hover:no-underline" style="color: var(--color-navy-60);">Tüm segmentleri gör</a>
            </p>
            @else
            <h1 class="text-4xl mb-4">Uygulama Alanını Seçin</h1>
            <p class="text-gray-600 leading-relaxed">
                Ürününüzün kullanılacağı alanı seçerek başlayın.
            </p>
            @endif
        </div>

        {{-- Adım 1: Kök Düğümler --}}
        <div class="max-w-3xl mx-auto grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse ($rootNodes as $node)
            <a href="{{ route('finder.step', $node->slug) }}"
               class="card p-6 group block text-center">
                @if ($node->segment)
                <div class="mb-3 flex justify-center">
                    <x-segment-badge :segment="$node->segment" />
                </div>
                @endif
                <h3 class="font-medium transition-colors" style="color: var(--color-navy);">
                    {{ $node->label }}
                </h3>
                @if ($node->description)
                <p class="text-xs text-gray-500 mt-2 leading-relaxed">{{ $node->description }}</p>
                @endif
                <div class="mt-4 text-xs font-medium" style="color: var(--color-navy-40);">Seç →</div>
            </a>
            @empty
            <div class="col-span-3 text-center py-16 text-gray-400">
                <p class="mb-4">Henüz kategori ağacı oluşturulmamış.</p>
                <a href="{{ route('products.index', 'dogal-tas') }}" class="btn btn-secondary">Ürünleri Listele</a>
            </div>
            @endforelse
        </div>

    </div>

</x-layouts.app>
