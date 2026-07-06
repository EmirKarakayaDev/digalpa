@php
    $segments = \App\Models\Segment::where('is_active', true)->orderBy('sort_order')->get();
    $currentRoute = request()->route()?->getName();
    $siteSettings = \App\Models\SiteSetting::group('site');
    $logoName = $siteSettings['site.company_name'] ?? 'Digalpa';
    $logoSub  = $siteSettings['site.logo_subtitle'] ?? '';
@endphp

<nav class="nav-wrapper">
    <div class="container-content flex items-center justify-between w-full">

        {{-- Logo --}}
        <a href="{{ route('home') }}" class="flex items-center gap-2 shrink-0">
            <span class="font-serif text-white text-xl tracking-tight">{{ $logoName }}</span>
            @if ($logoSub)
            <span class="hidden sm:block text-white/50 text-xs uppercase tracking-widest mt-1">{{ $logoSub }}</span>
            @endif
        </a>

        {{-- Masaüstü Menü --}}
        <div class="hidden lg:flex items-center gap-1">

            {{-- Hakkımızda --}}
            <a href="{{ route('about.index') }}" class="nav-link text-white/80 hover:text-white text-sm px-3 py-2 rounded transition-colors">
                Hakkımızda
            </a>

            {{-- Segmentler / Ürünler — Mega Menü --}}
            <div class="relative group">
                <button class="nav-link text-white/80 hover:text-white text-sm px-3 py-2 rounded transition-colors flex items-center gap-1">
                    Ürünler
                    <svg class="w-3.5 h-3.5 transition-transform group-hover:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                {{-- Mega Menü Paneli --}}
                <div class="absolute left-1/2 -translate-x-1/2 top-full pt-2 w-[680px] opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                    <div class="bg-white border border-gray-100 rounded-sm shadow-2xl p-6 grid grid-cols-3 gap-6">
                        @foreach ($segments as $segment)
                        <div>
                            <a href="{{ route('products.index', $segment->slug) }}"
                               class="block mb-3 group/seg">
                                <span class="segment-badge segment-badge--{{ $segment->color_key }}">
                                    {{ $segment->name }}
                                </span>
                            </a>
                            @if ($segment->description)
                            <p class="text-xs text-gray-500 leading-relaxed">
                                {{ Str::limit($segment->description, 80) }}
                            </p>
                            @endif
                            <a href="{{ route('products.index', $segment->slug) }}"
                               class="mt-2 inline-flex items-center gap-1 text-xs text-navy-60 hover:text-navy font-medium transition-colors">
                                Tümünü Gör →
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <a href="{{ route('finder.index') }}"
               class="nav-link text-white/80 hover:text-white text-sm px-3 py-2 rounded transition-colors">
                Ürün Bulucu
            </a>

            <a href="{{ route('projects.index') }}"
               class="nav-link text-white/80 hover:text-white text-sm px-3 py-2 rounded transition-colors">
                Referanslar
            </a>

            <a href="{{ route('blog.index') }}"
               class="nav-link text-white/80 hover:text-white text-sm px-3 py-2 rounded transition-colors">
                Blog
            </a>

            <a href="{{ route('contact.index') }}"
               class="nav-link text-white/80 hover:text-white text-sm px-3 py-2 rounded transition-colors">
                İletişim
            </a>
        </div>

        {{-- CTA Butonu --}}
        <div class="hidden lg:flex items-center gap-3">
            <a href="{{ route('finder.index') }}" class="btn btn-finder text-sm py-2">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                Ürün Bul
            </a>
        </div>

        {{-- Mobil Hamburger --}}
        <button id="drawer-open-btn" class="lg:hidden text-white p-2 -mr-2" aria-label="Menüyü aç">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
    </div>
</nav>

{{-- Mobil Drawer — sağdan kayan panel (Brief §03) --}}
<div id="drawer-overlay"
     class="fixed inset-0 bg-black/50 z-40 hidden lg:hidden"
     aria-hidden="true"></div>

<div id="drawer-panel"
     class="fixed top-0 right-0 h-full w-72 z-50 flex flex-col lg:hidden
            translate-x-full transition-transform duration-300 ease-in-out"
     style="background-color: var(--color-navy);">

    {{-- Drawer başlık --}}
    <div class="flex items-center justify-between px-5 py-4 border-b border-white/10 shrink-0">
        <span class="font-serif text-white text-lg">{{ $logoName }}</span>
        <button id="drawer-close-btn" class="text-white/70 hover:text-white p-1" aria-label="Kapat">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    {{-- Drawer içerik --}}
    <div class="flex-1 overflow-y-auto px-5 py-5 flex flex-col">

        {{-- Ürün Bul — en üstte (Brief §03) --}}
        <a href="{{ route('finder.index') }}"
           class="btn btn-finder text-sm py-3 justify-center mb-5">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            Ürün Bul
        </a>

        {{-- Ürünler accordion --}}
        <div class="border-b border-white/10">
            <button id="drawer-products-btn"
                    class="w-full flex items-center justify-between text-white/80 hover:text-white py-3 text-sm">
                <span>Ürünler</span>
                <svg id="drawer-products-chevron" class="w-4 h-4 transition-transform duration-200"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            <div id="drawer-products-list" class="hidden pb-2">
                @foreach ($segments as $segment)
                <a href="{{ route('products.index', $segment->slug) }}"
                   class="flex items-center gap-2.5 text-white/70 hover:text-white py-2.5 text-sm pl-2">
                    <span class="w-2 h-2 rounded-full shrink-0"
                          style="background-color: var(--color-{{ $segment->color_key }})"></span>
                    {{ $segment->name }}
                </a>
                @endforeach
            </div>
        </div>

        <a href="{{ route('about.index') }}" class="text-white/80 hover:text-white py-3 text-sm border-b border-white/10">Hakkımızda</a>
        <a href="{{ route('projects.index') }}" class="text-white/80 hover:text-white py-3 text-sm border-b border-white/10">Referanslar</a>
        <a href="{{ route('blog.index') }}" class="text-white/80 hover:text-white py-3 text-sm border-b border-white/10">Blog</a>
        <a href="{{ route('contact.index') }}" class="text-white/80 hover:text-white py-3 text-sm">İletişim</a>
    </div>
</div>

<script>
(function () {
    var openBtn  = document.getElementById('drawer-open-btn');
    var closeBtn = document.getElementById('drawer-close-btn');
    var overlay  = document.getElementById('drawer-overlay');
    var panel    = document.getElementById('drawer-panel');
    var prodBtn  = document.getElementById('drawer-products-btn');
    var prodList = document.getElementById('drawer-products-list');
    var chevron  = document.getElementById('drawer-products-chevron');

    function openDrawer() {
        overlay.classList.remove('hidden');
        panel.classList.remove('translate-x-full');
        document.body.style.overflow = 'hidden';
    }

    function closeDrawer() {
        panel.classList.add('translate-x-full');
        overlay.classList.add('hidden');
        document.body.style.overflow = '';
    }

    openBtn.addEventListener('click', openDrawer);
    closeBtn.addEventListener('click', closeDrawer);
    overlay.addEventListener('click', closeDrawer);

    prodBtn.addEventListener('click', function () {
        var open = !prodList.classList.contains('hidden');
        prodList.classList.toggle('hidden');
        chevron.style.transform = open ? '' : 'rotate(180deg)';
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closeDrawer();
    });
}());
</script>
