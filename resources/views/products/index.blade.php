<x-layouts.app :title="$segment->name . ' Ürünleri — Digalpa'"
               :description="$segment->description">

    <x-breadcrumb :items="[$segment->name => null]" />

    {{-- Başlık --}}
    <div class="bg-gray-50 border-b border-gray-100">
        <div class="container-content py-10">
            <h1 class="text-4xl">{{ $segment->name }}</h1>
            @if ($segment->description)
            <p class="text-gray-600 mt-2 max-w-xl">{{ $segment->description }}</p>
            @endif
        </div>
    </div>

    <div class="container-content py-10">
        <div class="flex flex-col lg:flex-row gap-10">

            {{-- Sol: Kategoriler --}}
            <aside class="lg:w-56 shrink-0">
                <div class="label-caps mb-3">Kategoriler</div>
                <ul class="space-y-1">
                    <li>
                        <a href="{{ route('products.index', $segment->slug) }}"
                           class="block text-sm py-1.5 px-2 rounded transition-colors {{ !$activeCategory ? 'text-navy font-medium bg-navy-10' : 'text-gray-600 hover:text-navy' }}">
                            Tümü
                        </a>
                    </li>
                    @foreach ($categories as $category)
                    <li>
                        <a href="?kategori={{ $category->id }}"
                           class="block text-sm py-1.5 px-2 rounded transition-colors {{ $activeCategory?->id === $category->id ? 'text-navy font-medium bg-navy-10' : 'text-gray-600 hover:text-navy' }}">
                            {{ $category->name }}
                        </a>
                        @if ($category->children->isNotEmpty())
                        <ul class="ml-4 mt-1 space-y-1">
                            @foreach ($category->children as $child)
                            <li>
                                <a href="?kategori={{ $child->id }}"
                                   class="block text-xs py-1 px-2 rounded transition-colors {{ $activeCategory?->id === $child->id ? 'text-navy font-medium' : 'text-gray-500 hover:text-navy' }}">
                                    {{ $child->name }}
                                </a>
                            </li>
                            @endforeach
                        </ul>
                        @endif
                    </li>
                    @endforeach
                </ul>
            </aside>

            {{-- Sağ: Ürün Izgarası --}}
            <div class="flex-1 min-w-0">
                @if ($products->isEmpty())
                <div class="text-center py-16 text-gray-400">
                    <p class="text-lg">Bu kategoride ürün bulunamadı.</p>
                </div>
                @else
                <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-5">
                    @foreach ($products as $product)
                    <a href="{{ route('products.show', $product->slug) }}" class="card group block">
                        @if ($product->image)
                        <div class="aspect-square overflow-hidden bg-gray-50">
                            <img src="{{ Storage::url($product->image) }}"
                                 alt="{{ $product->name }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        </div>
                        @else
                        <div class="aspect-square bg-gray-100 flex items-center justify-center">
                            <svg class="w-10 h-10 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
                            </svg>
                        </div>
                        @endif
                        <div class="p-4">
                            <h3 class="text-sm font-medium text-navy leading-snug group-hover:text-navy-60 transition-colors">
                                {{ $product->name }}
                            </h3>
                            @if ($product->short_description)
                            <p class="text-xs text-gray-500 mt-1 line-clamp-2">{{ $product->short_description }}</p>
                            @endif
                        </div>
                    </a>
                    @endforeach
                </div>

                {{-- Sayfalama --}}
                @if ($products->hasPages())
                <div class="mt-10">
                    {{ $products->links() }}
                </div>
                @endif
                @endif
            </div>

        </div>
    </div>

</x-layouts.app>
