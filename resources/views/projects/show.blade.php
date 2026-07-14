<x-layouts.app :title="($project->meta_title ?: $project->title) . ' — Digalpa'"
               :description="$project->meta_description ?: $project->description">

    <x-breadcrumb :items="['Referans Projeler' => route('projects.index'), $project->title => null]" />

    <div class="container-content py-10">
        <div class="flex flex-col lg:flex-row gap-12">

            {{-- İçerik --}}
            <article class="lg:w-[65%] min-w-0">
                @if ($project->segment)
                <x-segment-badge :segment="$project->segment" />
                @endif

                <h1 class="mt-4 text-4xl lg:text-5xl">{{ $project->title }}</h1>

                {{-- Meta bilgiler --}}
                <div class="flex flex-wrap items-center gap-4 mt-4 pb-4 border-b border-gray-100 text-sm text-gray-500">
                    @if ($project->client)
                    <span class="flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15"/>
                        </svg>
                        {{ $project->client }}
                    </span>
                    @endif
                    @if ($project->location)
                    <span class="flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>
                        </svg>
                        {{ $project->location }}
                    </span>
                    @endif
                    @if ($project->year)
                    <span>{{ $project->year }}</span>
                    @endif
                </div>

                {{-- Ana görsel --}}
                @if ($project->image)
                <div class="mt-8 aspect-video overflow-hidden rounded-sm bg-gray-100">
                    <img src="{{ Storage::url($project->image) }}" alt="{{ $project->title }}"
                         class="w-full h-full object-cover">
                </div>
                @endif

                {{-- Açıklama --}}
                @if ($project->description)
                <p class="text-lg text-gray-600 leading-relaxed mt-8 font-medium">{{ $project->description }}</p>
                @endif

                {{-- Detay içerik --}}
                @if ($project->content)
                <div class="prose prose-sm max-w-none text-gray-700 leading-relaxed mt-8">
                    {!! $project->content !!}
                </div>
                @endif

                {{-- Galeri — 2x2 grid + "N görsel daha" + lightbox (Brief §09) --}}
                @if (!empty($project->gallery) && count($project->gallery))
                @php
                    $galleryUrls = collect($project->gallery)->map(fn ($img) => Storage::url($img))->all();
                    $visibleCount = min(4, count($galleryUrls));
                    $remaining = count($galleryUrls) - 4;
                @endphp
                <div class="mt-10">
                    <h3 class="mb-4">Proje Görselleri</h3>
                    <div class="project-gallery grid grid-cols-2 gap-3" data-gallery="{{ json_encode($galleryUrls) }}">
                        @for ($i = 0; $i < $visibleCount; $i++)
                        <button type="button" class="gallery-thumb relative aspect-square overflow-hidden rounded-sm bg-gray-100" data-index="{{ $i }}">
                            <img src="{{ $galleryUrls[$i] }}" alt="" class="w-full h-full object-cover">
                            @if ($i === 3 && $remaining > 0)
                            <span class="absolute inset-0 bg-navy/70 flex items-center justify-center text-white text-lg font-medium">
                                +{{ $remaining }} görsel daha
                            </span>
                            @endif
                        </button>
                        @endfor
                    </div>
                </div>
                @endif
            </article>

            {{-- Sidebar --}}
            <aside class="lg:w-[35%] shrink-0">
                <div class="sticky top-[104px] space-y-4">

                    {{-- Kullanılan Ürünler — gerçek ürüne bağlıysa linkli, değilse serbest metin
                         (Brief §09: "sidebar ürün sayfalarına link veriyor") --}}
                    @if ($project->products->isNotEmpty())
                    <div class="border border-gray-100 rounded-sm p-5">
                        <div class="label-caps mb-3">Kullanılan Ürünler</div>
                        <ul class="space-y-2">
                            @foreach ($project->products as $product)
                            <li>
                                <a href="{{ route('products.show', $product->slug) }}"
                                   class="text-sm text-gray-700 hover:text-navy transition-colors flex items-center gap-2">
                                    <span class="w-1.5 h-1.5 rounded-full bg-navy-40 shrink-0"></span>
                                    {{ $product->name }}
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @elseif (!empty($project->used_products) && count($project->used_products))
                    <div class="border border-gray-100 rounded-sm p-5">
                        <div class="label-caps mb-3">Kullanılan Ürünler</div>
                        <ul class="space-y-2">
                            @foreach ($project->used_products as $productName)
                            <li class="text-sm text-gray-700 flex items-center gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-navy-40 shrink-0"></span>
                                {{ $productName }}
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    {{-- Benzer proje yönlendirme --}}
                    <div class="border border-gray-100 rounded-sm p-5 bg-gray-50">
                        <div class="label-caps mb-2">Teknik Destek</div>
                        <p class="text-sm text-gray-600 mb-3">
                            Benzer bir proje için teklif almak ister misiniz?
                        </p>
                        <a href="{{ route('contact.index') }}" class="btn btn-primary w-full justify-center text-sm py-2">
                            İletişime Geç
                        </a>
                    </div>

                </div>
            </aside>

        </div>
    </div>

    {{-- Galeri Lightbox --}}
    <div id="gallery-lightbox" class="fixed inset-0 z-50 hidden items-center justify-center bg-navy/90 p-4">
        <button type="button" id="gallery-lightbox-close" aria-label="Kapat"
                class="absolute top-4 right-4 text-white/80 hover:text-white">
            <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
        <button type="button" id="gallery-lightbox-prev" aria-label="Önceki"
                class="absolute left-2 md:left-6 top-1/2 -translate-y-1/2 text-white/80 hover:text-white">
            <svg class="w-9 h-9" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
        </button>
        <img id="gallery-lightbox-img" src="" alt="" class="max-h-[85vh] max-w-[90vw] object-contain rounded-sm">
        <button type="button" id="gallery-lightbox-next" aria-label="Sonraki"
                class="absolute right-2 md:right-6 top-1/2 -translate-y-1/2 text-white/80 hover:text-white">
            <svg class="w-9 h-9" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
            </svg>
        </button>
        <div id="gallery-lightbox-counter" class="absolute bottom-4 left-1/2 -translate-x-1/2 text-white/70 text-sm"></div>
    </div>

</x-layouts.app>
