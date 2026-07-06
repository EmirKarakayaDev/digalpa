@php
    $segments      = \App\Models\Segment::where('is_active', true)->orderBy('sort_order')->get();
    $siteSettings  = \App\Models\SiteSetting::group('site');
@endphp

<footer class="bg-navy text-white mt-24">
    <div class="container-content py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">

            {{-- Marka --}}
            <div class="lg:col-span-1">
                <div class="font-serif text-2xl mb-3">Digalpa</div>
                <p class="text-white/60 text-sm leading-relaxed">
                    {{ $siteSettings['site.footer_tagline'] }}
                </p>
            </div>

            {{-- Ürünler --}}
            <div>
                <div class="label-caps text-white/50 mb-4">Ürünler</div>
                <ul class="space-y-2">
                    @foreach ($segments as $segment)
                    <li>
                        <a href="{{ route('products.index', $segment->slug) }}"
                           class="text-white/70 hover:text-white text-sm transition-colors">
                            {{ $segment->name }}
                        </a>
                    </li>
                    @endforeach
                    <li>
                        <a href="{{ route('finder.index') }}"
                           class="text-white/70 hover:text-white text-sm transition-colors">
                            Ürün Bulucu
                        </a>
                    </li>
                </ul>
            </div>

            {{-- Kurumsal --}}
            <div>
                <div class="label-caps text-white/50 mb-4">Kurumsal</div>
                <ul class="space-y-2">
                    <li><a href="{{ route('projects.index') }}" class="text-white/70 hover:text-white text-sm transition-colors">Referans Projeler</a></li>
                    <li><a href="{{ route('blog.index') }}" class="text-white/70 hover:text-white text-sm transition-colors">Blog</a></li>
                    <li><a href="{{ route('contact.index') }}" class="text-white/70 hover:text-white text-sm transition-colors">İletişim</a></li>
                </ul>
            </div>

            {{-- İletişim --}}
            <div>
                <div class="label-caps text-white/50 mb-4">İletişim</div>
                <ul class="space-y-3 text-sm text-white/70">
                    @if ($siteSettings['site.address'])
                    <li class="flex items-start gap-2">
                        <svg class="w-4 h-4 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>
                        </svg>
                        {{ $siteSettings['site.address'] }}
                    </li>
                    @endif
                    @if ($siteSettings['site.phone'])
                    <li class="flex items-center gap-2">
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/>
                        </svg>
                        <a href="tel:{{ preg_replace('/\s+/', '', $siteSettings['site.phone']) }}" class="hover:text-white transition-colors">
                            {{ $siteSettings['site.phone'] }}
                        </a>
                    </li>
                    @endif
                    @if ($siteSettings['site.email'])
                    <li class="flex items-center gap-2">
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
                        </svg>
                        <a href="mailto:{{ $siteSettings['site.email'] }}" class="hover:text-white transition-colors">
                            {{ $siteSettings['site.email'] }}
                        </a>
                    </li>
                    @endif
                </ul>
            </div>
        </div>

        {{-- Alt çizgi --}}
        <div class="border-t border-white/10 mt-12 pt-6 flex flex-col sm:flex-row justify-between items-center gap-4">
            <p class="text-white/40 text-xs">
                &copy; {{ date('Y') }} Digalpa Kimya Sanayi A.Ş. Tüm hakları saklıdır.
            </p>
            <div class="flex items-center gap-6">
                <div class="flex gap-4">
                    <a href="#" class="text-white/40 hover:text-white/70 text-xs transition-colors">Gizlilik Politikası</a>
                    <a href="#" class="text-white/40 hover:text-white/70 text-xs transition-colors">KVKK</a>
                </div>
                {{-- 3 Segment Noktası (Brief §09) --}}
                <div class="flex items-center gap-2">
                    @foreach ($segments as $segment)
                    <a href="{{ route('products.index', $segment->slug) }}"
                       title="{{ $segment->name }}"
                       class="w-2.5 h-2.5 rounded-full transition-opacity hover:opacity-100 opacity-60"
                       style="background-color: var(--color-{{ $segment->color_key }});"></a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</footer>
