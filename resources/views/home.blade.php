<x-layouts.app title="Digalpa Kimya Sanayi A.Ş. — Yapı Kimyasalları">

    {{-- §02 Hero — 560px, sol metin + sağ mini finder, 3 istatistik --}}
    {{-- .hero-under-nav: hero'yu sticky nav'ın normal kutusunun arkasına çeker,
         böylece şeffaf nav sayfa en üstteyken de hero'nun üzerinde durur --}}
    <section class="hero-under-nav relative text-white overflow-hidden" style="min-height: 560px; background-color: var(--color-navy);">
        @if (!empty($home['home.hero_image']))
        <div class="absolute inset-0"
             style="background-image: url('{{ Storage::url($home['home.hero_image']) }}'); background-size: cover; background-position: center;">
            <div class="absolute inset-0" style="background-color: rgba(11,37,69,0.78);"></div>
        </div>
        @endif

        {{-- Şeffaf nav'ın arkasında her zaman okunur bir zemin bırakan üst karartma (Brief §03) --}}
        <div class="hero-nav-fade absolute inset-x-0 top-0 h-32 z-[5]" aria-hidden="true"></div>

        <div class="container-content py-16 lg:py-20 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-5 gap-12 items-center">

                {{-- Sol: Metin + istatistik (%60) --}}
                <div class="lg:col-span-3">
                    <div class="label-caps text-white/50 mb-4">{{ $home['home.hero_label'] }}</div>
                    <h1 class="text-white mb-6">
                        {!! nl2br(e(str_replace('\n', "\n", $home['home.hero_title']))) !!}
                    </h1>
                    <p class="text-white/70 text-lg leading-relaxed mb-8 max-w-lg">
                        {{ $home['home.hero_body'] }}
                    </p>
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('finder.index') }}" class="btn btn-finder">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            Ürün Bulucu
                        </a>
                        <a href="{{ route('contact.index') }}" class="btn btn-secondary border-white/30 text-white hover:bg-white hover:text-navy">
                            Teknik Destek
                        </a>
                    </div>

                    {{-- 3 İstatistik --}}
                    <div class="mt-12 pt-8 border-t border-white/10 grid grid-cols-3 gap-6">
                        <div>
                            <div class="text-3xl font-semibold text-white">{{ $home['home.stat1_value'] }}</div>
                            <div class="text-sm text-white/50 mt-1">{{ $home['home.stat1_label'] }}</div>
                        </div>
                        <div>
                            <div class="text-3xl font-semibold text-white">{{ $home['home.stat2_value'] }}</div>
                            <div class="text-sm text-white/50 mt-1">{{ $home['home.stat2_label'] }}</div>
                        </div>
                        <div>
                            <div class="text-3xl font-semibold text-white">{{ $home['home.stat3_value'] }}</div>
                            <div class="text-sm text-white/50 mt-1">{{ $home['home.stat3_label'] }}</div>
                        </div>
                    </div>
                </div>

                {{-- Sağ: Mini Finder Widget (%40) --}}
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-sm p-6 shadow-2xl">
                        <div class="label-caps mb-3" style="color: var(--color-navy-60);">Ürün Bulucu</div>
                        <h3 class="font-medium leading-snug mb-5" style="font-size: 18px; color: var(--color-navy);">
                            {!! nl2br(e($home['home.finder_subtitle'] ?? '')) !!}
                        </h3>
                        <div class="space-y-2">
                            @foreach ($segments as $segment)
                            <a href="{{ route('finder.index', ['segment' => $segment->slug]) }}"
                               class="flex items-center justify-between p-3 border border-gray-200 rounded-sm hover:border-navy transition-all group"
                               style="--tw-border-opacity: 1;">
                                <div class="flex items-center gap-3">
                                    <span class="w-2.5 h-2.5 rounded-full flex-shrink-0"
                                          style="background-color: var(--color-{{ $segment->color_key }})"></span>
                                    <span class="text-sm font-medium" style="color: var(--color-navy);">{{ $segment->name }}</span>
                                </div>
                                <svg class="w-4 h-4 text-gray-400 group-hover:text-navy transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                            @endforeach
                        </div>
                        <a href="{{ route('finder.index') }}"
                           class="mt-4 block text-center text-sm hover:underline py-2 transition-colors"
                           style="color: var(--color-navy-60);">
                            Tüm ürün bulucu için tıklayın →
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- §03 Segment Kartları --}}
    <section class="py-20 bg-gray-50">
        <div class="container-content">
            <div class="mb-10">
                <div class="label-caps mb-2">Uygulama Alanları</div>
                <h2>Sektörel Çözümlerimiz</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach ($segments as $segment)
                <a href="{{ route('products.index', $segment->slug) }}"
                   class="card card-stripe--{{ $segment->color_key }} p-6 block group">
                    <div class="mb-4">
                        <x-segment-badge :segment="$segment" />
                    </div>
                    @if ($segment->description)
                    <p class="text-gray-600 text-sm leading-relaxed mb-4">
                        {{ Str::limit($segment->description, 120) }}
                    </p>
                    @endif
                    <span class="text-sm font-medium transition-colors"
                          style="color: var(--color-navy-60);">
                        Ürünleri Gör →
                    </span>
                </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- §04 Product Finder Bandı — lacivert, sol metin + sağ 3 adım kartı --}}
    <section class="py-20 bg-navy text-white">
        <div class="container-content">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">

                {{-- Sol: Metin --}}
                <div>
                    <div class="label-caps text-white/50 mb-4">{{ $home['home.finder_band_label'] ?? '' }}</div>
                    <h2 class="text-white mb-4">{!! nl2br(e(str_replace('\n', "\n", $home['home.finder_band_title'] ?? ''))) !!}</h2>
                    <p class="text-white/70 leading-relaxed mb-8">
                        {{ $home['home.finder_band_body'] ?? '' }}
                    </p>
                    <a href="{{ route('finder.index') }}" class="btn btn-secondary border-white/30 text-white hover:bg-white hover:text-navy">
                        Ürün Bulucuyu Başlat →
                    </a>
                </div>

                {{-- Sağ: 3 Adım Kartı --}}
                <div class="grid grid-cols-3 gap-4">
                    <div class="rounded-sm p-5 text-center" style="background-color: rgba(255,255,255,0.1);">
                        <div class="w-9 h-9 rounded-full flex items-center justify-center font-semibold text-sm mx-auto mb-3"
                             style="background-color: rgba(255,255,255,0.15); color: #fff;">1</div>
                        <div class="text-sm font-medium text-white mb-2">Segmenti Seç</div>
                        <div class="text-xs leading-relaxed" style="color: rgba(255,255,255,0.5);">
                            Doğal taş, inşaat veya marine
                        </div>
                    </div>
                    <div class="rounded-sm p-5 text-center" style="background-color: rgba(255,255,255,0.1);">
                        <div class="w-9 h-9 rounded-full flex items-center justify-center font-semibold text-sm mx-auto mb-3"
                             style="background-color: rgba(255,255,255,0.15); color: #fff;">2</div>
                        <div class="text-sm font-medium text-white mb-2">Uygulamayı Belirt</div>
                        <div class="text-xs leading-relaxed" style="color: rgba(255,255,255,0.5);">
                            Koruma, temizlik, montaj...
                        </div>
                    </div>
                    <div class="rounded-sm p-5 text-center" style="background-color: rgba(255,255,255,0.1);">
                        <div class="w-9 h-9 rounded-full flex items-center justify-center font-semibold text-sm mx-auto mb-3"
                             style="background-color: rgba(255,255,255,0.15); color: #fff;">3</div>
                        <div class="text-sm font-medium text-white mb-2">Ürünü Keşfet</div>
                        <div class="text-xs leading-relaxed" style="color: rgba(255,255,255,0.5);">
                            1–3 önerilen ürün
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- §05 Öne Çıkan Ürünler — 4 grid, segment çizgisi, TDS linki --}}
    @if ($featuredProducts->isNotEmpty())
    <section class="py-20">
        <div class="container-content">
            <div class="flex items-end justify-between mb-10">
                <div>
                    <div class="label-caps mb-2">Ürünler</div>
                    <h2>Öne Çıkan Ürünler</h2>
                </div>
                <a href="{{ route('finder.index') }}" class="btn btn-ghost hidden sm:inline-flex">Tümünü Bul →</a>
            </div>

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-5">
                @foreach ($featuredProducts as $product)
                <div class="card card-stripe--{{ $product->categories->first()?->segment?->color_key ?? 'stone' }} group">
                    <a href="{{ route('products.show', $product->slug) }}" class="block">
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
                        <div class="p-4 pb-2">
                            <h3 class="text-sm font-medium leading-snug mb-1 group-hover:text-navy-60 transition-colors"
                                style="color: var(--color-navy);">
                                {{ $product->name }}
                            </h3>
                            @if ($product->short_description)
                            <p class="text-xs text-gray-500 leading-relaxed line-clamp-2">{{ $product->short_description }}</p>
                            @endif
                        </div>
                    </a>
                    {{-- TDS Linki --}}
                    <div class="px-4 pb-3 pt-1 border-t border-gray-100 mt-auto">
                        <button type="button"
                                onclick="openDocModal({{ $product->id }}, '{{ addslashes($product->name) }}')"
                                class="text-xs flex items-center gap-1 transition-colors"
                                style="color: var(--color-navy-60);">
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            TDS / SDS İndir
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- §06 Neden Digalpa — 3 güven kartı --}}
    <section class="py-20">
        <div class="container-content">
            <div class="mb-10 text-center">
                <div class="label-caps mb-2">Neden Digalpa</div>
                <h2>{{ $home['home.trust_title'] ?? '' }}</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <div class="border border-gray-200 rounded-sm p-8 bg-white">
                    <div class="w-12 h-12 rounded-sm flex items-center justify-center mb-5"
                         style="background-color: var(--color-navy-10);">
                        <svg class="w-6 h-6" style="color: var(--color-navy);" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="font-medium mb-3" style="color: var(--color-navy);">{{ $home['home.trust1_title'] ?? '' }}</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">{{ $home['home.trust1_body'] ?? '' }}</p>
                </div>

                <div class="border border-gray-200 rounded-sm p-8 bg-white">
                    <div class="w-12 h-12 rounded-sm flex items-center justify-center mb-5"
                         style="background-color: var(--color-navy-10);">
                        <svg class="w-6 h-6" style="color: var(--color-navy);" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>
                        </svg>
                    </div>
                    <h3 class="font-medium mb-3" style="color: var(--color-navy);">{{ $home['home.trust2_title'] ?? '' }}</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">{{ $home['home.trust2_body'] ?? '' }}</p>
                </div>

                <div class="border border-gray-200 rounded-sm p-8 bg-white">
                    <div class="w-12 h-12 rounded-sm flex items-center justify-center mb-5"
                         style="background-color: var(--color-navy-10);">
                        <svg class="w-6 h-6" style="color: var(--color-navy);" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12"/>
                        </svg>
                    </div>
                    <h3 class="font-medium mb-3" style="color: var(--color-navy);">{{ $home['home.trust3_title'] ?? '' }}</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">{{ $home['home.trust3_body'] ?? '' }}</p>
                </div>

            </div>
        </div>
    </section>

    {{-- §07 AKEMI Ortaklık Bandı — #E8EFF8 zemin (logo için izin bekleniyor) --}}
    <section class="py-14" style="background-color: var(--color-navy-10);">
        <div class="container-content">
            <div class="flex flex-col md:flex-row items-center justify-between gap-8">

                {{-- Logo + başlık --}}
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 rounded-sm border-2 border-dashed border-navy/20 flex items-center justify-center flex-shrink-0"
                         style="background-color: rgba(11,37,69,0.05);">
                        <span class="text-[10px] text-center leading-tight font-medium"
                              style="color: rgba(11,37,69,0.35);">AKEMI<br>Logo</span>
                    </div>
                    <div>
                        <div class="label-caps mb-1" style="color: var(--color-navy-60);">Resmi Türkiye Distribütörü</div>
                        <div class="text-xl font-semibold" style="color: var(--color-navy);">AKEMI × Digalpa</div>
                    </div>
                </div>

                {{-- 3 badge --}}
                <div class="flex flex-col sm:flex-row gap-3">
                    @foreach (['akemi.badge1', 'akemi.badge2', 'akemi.badge3'] as $key)
                    <div class="flex items-center gap-2 bg-white rounded-sm px-4 py-3 border border-navy/10">
                        <svg class="w-4 h-4 flex-shrink-0" style="color: var(--color-navy);" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="text-sm font-medium" style="color: var(--color-navy);">{{ $akemi[$key] }}</span>
                    </div>
                    @endforeach
                </div>

            </div>
        </div>
    </section>

    {{-- §08 Öne Çıkan Projeler --}}
    @if ($featuredProjects->isNotEmpty())
    <section class="py-20 bg-gray-50">
        <div class="container-content">
            <div class="flex items-end justify-between mb-10">
                <div>
                    <div class="label-caps mb-2">Referanslar</div>
                    <h2>Seçili Projeler</h2>
                </div>
                <a href="{{ route('projects.index') }}" class="btn btn-ghost hidden sm:inline-flex">Tüm Projeler →</a>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($featuredProjects as $project)
                <a href="{{ route('projects.show', $project->slug) }}" class="card group block overflow-hidden">
                    @if ($project->image)
                    <div class="aspect-video overflow-hidden">
                        <img src="{{ Storage::url($project->image) }}"
                             alt="{{ $project->title }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    </div>
                    @else
                    <div class="aspect-video bg-gray-100"></div>
                    @endif
                    <div class="p-5">
                        @if ($project->segment)
                        <x-segment-badge :segment="$project->segment" />
                        @endif
                        <h3 class="mt-3 font-medium leading-snug" style="color: var(--color-navy);">{{ $project->title }}</h3>
                        @if ($project->client || $project->location)
                        <p class="text-xs text-gray-500 mt-1">
                            {{ implode(' — ', array_filter([$project->client, $project->location])) }}
                        </p>
                        @endif
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- Blog --}}
    @if ($latestPosts->isNotEmpty())
    <section class="py-20">
        <div class="container-content">
            <div class="flex items-end justify-between mb-10">
                <div>
                    <div class="label-caps mb-2">Blog</div>
                    <h2>Son Yazılar</h2>
                </div>
                <a href="{{ route('blog.index') }}" class="btn btn-ghost hidden sm:inline-flex">Tüm Yazılar →</a>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach ($latestPosts as $post)
                <a href="{{ route('blog.show', $post->slug) }}" class="group block">
                    @if ($post->image)
                    <div class="aspect-video overflow-hidden rounded-sm mb-4">
                        <img src="{{ Storage::url($post->image) }}"
                             alt="{{ $post->title }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    </div>
                    @endif
                    <div class="label-caps mb-2">{{ $post->published_at->format('d M Y') }}</div>
                    <h3 class="font-medium leading-snug group-hover:text-navy-60 transition-colors"
                        style="color: var(--color-navy);">
                        {{ $post->title }}
                    </h3>
                    @if ($post->excerpt)
                    <p class="text-sm text-gray-500 mt-2 line-clamp-2">{{ $post->excerpt }}</p>
                    @endif
                </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- İletişim CTA --}}
    <section class="py-16 border-t border-gray-100">
        <div class="container-content text-center">
            <h2 class="mb-4">Teknik Destek Alın</h2>
            <p class="text-gray-600 mb-6 max-w-md mx-auto">
                Uzman ekibimiz doğru ürün seçimi ve uygulama konusunda yanınızda.
            </p>
            <a href="{{ route('contact.index') }}" class="btn btn-primary">İletişime Geç</a>
        </div>
    </section>

</x-layouts.app>
