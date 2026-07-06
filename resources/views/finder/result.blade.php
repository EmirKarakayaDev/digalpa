<x-layouts.app :title="$node->label . ' için Ürünler — Digalpa'">

    <x-breadcrumb :items="['Ürün Bulucu' => route('finder.index'), $node->label => null]" />

    <div class="container-content py-16">

        {{-- Progress Bar — tüm adımlar tamamlandı --}}
        @php $steps = ['Segment', 'Uygulama', 'Detay']; @endphp
        <div class="max-w-xs mx-auto mb-12">
            <div class="flex items-start">
                @foreach ($steps as $i => $label)
                <div class="flex flex-col items-center {{ $i < count($steps) - 1 ? 'flex-1' : '' }}">
                    <div class="flex items-center w-full">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center bg-navy text-white flex-shrink-0">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        @if ($i < count($steps) - 1)
                        <div class="flex-1 h-px mx-2 bg-navy"></div>
                        @endif
                    </div>
                    <div class="text-xs mt-1.5 font-medium text-navy">{{ $label }}</div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="mb-10">
            <div class="label-caps mb-2">Ürün Bulucu Sonuçları</div>
            <h1 class="text-3xl">{{ $node->label }}</h1>
            @if ($node->description)
            <p class="text-gray-600 mt-2">{{ $node->description }}</p>
            @endif
        </div>

        @if ($products->isEmpty())
        <div class="text-center py-16">
            <p class="text-gray-500 text-lg mb-6">Bu uygulama için henüz ürün eklenmemiş.</p>
            <a href="{{ route('finder.index') }}" class="btn btn-secondary">← Yeniden Ara</a>
        </div>
        @else
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
            @foreach ($products as $product)
            <a href="{{ route('products.show', $product->slug) }}" class="card group block">
                @if ($product->image)
                <div class="aspect-square overflow-hidden bg-gray-50">
                    <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                </div>
                @else
                <div class="aspect-square bg-gray-100"></div>
                @endif
                <div class="p-4">
                    <h3 class="text-sm font-medium leading-snug transition-colors" style="color: var(--color-navy);">
                        {{ $product->name }}
                    </h3>
                    @if ($product->short_description)
                    <p class="text-xs text-gray-500 mt-1 line-clamp-2">{{ $product->short_description }}</p>
                    @endif
                </div>
            </a>
            @endforeach
        </div>

        <div class="mt-10">
            <a href="{{ route('finder.index') }}" class="btn btn-ghost">← Yeniden Ara</a>
        </div>
        @endif

    </div>

</x-layouts.app>
