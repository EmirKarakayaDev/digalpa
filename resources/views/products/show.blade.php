@php
    $primarySegment = $product->categories->first()?->segment;
    $breadcrumbItems = [];
    if ($primarySegment) {
        $breadcrumbItems[$primarySegment->name] = route('products.index', $primarySegment->slug);
    }
    $breadcrumbItems[$product->name] = null;
@endphp

<x-layouts.app :title="($product->meta_title ?: $product->name) . ' — Digalpa'"
               :description="$product->meta_description ?: $product->short_description">

    <x-breadcrumb :items="$breadcrumbItems" />

    <div class="container-content py-10 pb-24 lg:pb-10">
        <div class="flex flex-col lg:flex-row gap-12">

            {{-- Sol: %65 İçerik --}}
            <article class="lg:w-[65%] min-w-0">

                <div class="flex flex-wrap items-center gap-2">
                    @if ($primarySegment)
                    <x-segment-badge :segment="$primarySegment" />
                    @endif

                    <span class="segment-badge"
                          style="{{ match ($product->stock_status) {
                              'limited' => 'background-color:#FEF3C7;color:#B45309;border-color:#B45309;',
                              'out_of_stock' => 'background-color:#FEE2E2;color:#B91C1C;border-color:#B91C1C;',
                              default => 'background-color:#DCFCE7;color:#15803D;border-color:#15803D;',
                          } }}">
                        {{ $product->stockStatusLabel() }}
                    </span>
                </div>

                <h1 class="mt-4" style="font-size: 42px;">{{ $product->name }}</h1>

                @if ($product->short_description)
                <p class="text-lg text-gray-600 mt-4 leading-relaxed">{{ $product->short_description }}</p>
                @endif

                {{-- Galeri --}}
                @if ($product->gallery && count($product->gallery))
                <div class="mt-8 grid grid-cols-3 gap-3">
                    @if ($product->image)
                    <div class="col-span-2 aspect-video rounded-sm overflow-hidden bg-gray-100">
                        <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                    </div>
                    @endif
                    @foreach (array_slice($product->gallery, 0, 4) as $img)
                    <div class="aspect-square rounded-sm overflow-hidden bg-gray-100">
                        <img src="{{ Storage::url($img) }}" alt="" class="w-full h-full object-cover">
                    </div>
                    @endforeach
                </div>
                @elseif ($product->image)
                <div class="mt-8 aspect-video rounded-sm overflow-hidden bg-gray-100 max-w-lg">
                    <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                </div>
                @endif

                {{-- Açıklama --}}
                @if ($product->description)
                <div class="mt-10 prose prose-sm max-w-none text-gray-700 leading-relaxed">
                    {!! $product->description !!}
                </div>
                @endif

                {{-- Accordion Bölümler --}}
                <div class="mt-10 space-y-2">

                    {{-- 1. Teknik Özellikler (açık) --}}
                    @if (!empty($product->technical_specs))
                    <details class="accordion-item" open>
                        <summary>
                            <span>Teknik Özellikler</span>
                            <svg class="accordion-chevron w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </summary>
                        <div class="accordion-body p-0">
                            <div class="divide-y divide-gray-100">
                                @foreach ($product->technical_specs as $spec)
                                <div class="flex {{ $loop->even ? 'bg-gray-50' : 'bg-white' }}">
                                    <div class="w-2/5 px-5 py-3 text-xs font-medium text-gray-500 uppercase tracking-wide">
                                        {{ $spec['label'] ?? '' }}
                                    </div>
                                    <div class="flex-1 px-5 py-3 text-sm" style="color: var(--color-navy);">
                                        {{ $spec['value'] ?? '' }}
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </details>
                    @endif

                    {{-- 2. Uygulama Hesaplayıcı (açık) --}}
                    @if ($product->coverage_min || $product->coverage_max)
                    <details class="accordion-item" open>
                        <summary>
                            <span>Uygulama Hesaplayıcı</span>
                            <svg class="accordion-chevron w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </summary>
                        <div class="accordion-body">
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 mb-5">
                                <div>
                                    <label class="block text-xs text-gray-500 mb-1.5">Alan (m²)</label>
                                    <input type="number" id="calc-area" min="1" value="10"
                                           class="border border-gray-200 rounded px-3 py-2 w-full text-sm focus:outline-none focus:border-navy">
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-500 mb-1.5">Kat Sayısı</label>
                                    <select id="calc-coats"
                                            class="border border-gray-200 rounded px-3 py-2 w-full text-sm focus:outline-none focus:border-navy bg-white">
                                        <option value="1">1 kat</option>
                                        <option value="2" selected>2 kat</option>
                                        <option value="3">3 kat</option>
                                    </select>
                                </div>
                                <div class="col-span-2 sm:col-span-1">
                                    <div class="text-xs text-gray-500 mb-1.5">Tahmini İhtiyaç <span class="text-gray-400">(+%10 fire)</span></div>
                                    <div id="calc-result" class="text-2xl font-semibold py-1" style="color: var(--color-navy);">—</div>
                                </div>
                            </div>
                            <p class="text-xs text-gray-400">
                                Tüketim: {{ $product->coverage_min }}{{ $product->coverage_max && $product->coverage_max != $product->coverage_min ? ' – ' . $product->coverage_max : '' }}
                                {{ $product->coverage_unit ?: 'm²/L' }} · Fire payı hesaba dahildir.
                            </p>
                        </div>
                    </details>

                    <script>
                    (function() {
                        const areaEl  = document.getElementById('calc-area');
                        const coatsEl = document.getElementById('calc-coats');
                        const result  = document.getElementById('calc-result');
                        const minCov  = {{ $product->coverage_min ?? 0 }};
                        const maxCov  = {{ $product->coverage_max ?? $product->coverage_min ?? 0 }};
                        const fire    = 1.10;

                        function calculate() {
                            const area   = parseFloat(areaEl.value) || 0;
                            const coats  = parseInt(coatsEl.value) || 1;
                            if (!area || !minCov) { result.textContent = '—'; return; }
                            const effective = maxCov > 0 ? maxCov : minCov;
                            const low  = ((area * coats) / effective * fire).toFixed(1);
                            const high = ((area * coats) / minCov  * fire).toFixed(1);
                            result.textContent = (minCov !== effective && low !== high)
                                ? low + ' – ' + high + ' L'
                                : high + ' L';
                        }

                        areaEl.addEventListener('input', calculate);
                        coatsEl.addEventListener('change', calculate);
                        calculate();
                    })();
                    </script>
                    @endif

                    {{-- 3. Uygulama Adımları (KAPALI — Brief §05 accordion sırası) --}}
                    @if (!empty($product->application_steps))
                    <details class="accordion-item">
                        <summary>
                            <span>Uygulama Adımları</span>
                            <svg class="accordion-chevron w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </summary>
                        <div class="accordion-body p-0">
                            <ol class="divide-y divide-gray-100">
                                @foreach ($product->application_steps as $step)
                                <li class="flex gap-4 px-5 py-4">
                                    <span class="w-6 h-6 rounded-full flex items-center justify-center text-xs font-semibold shrink-0"
                                          style="background-color: var(--color-navy-10); color: var(--color-navy);">
                                        {{ $loop->iteration }}
                                    </span>
                                    <div>
                                        <p class="text-sm font-medium" style="color: var(--color-navy);">{{ $step['title'] ?? '' }}</p>
                                        @if (!empty($step['description']))
                                        <p class="text-sm text-gray-600 mt-1 leading-relaxed">{{ $step['description'] }}</p>
                                        @endif
                                    </div>
                                </li>
                                @endforeach
                            </ol>
                        </div>
                    </details>
                    @endif

                    {{-- 4. Tamamlayıcı Ürünler (açık, varsa — admin seçimi, Brief §05) --}}
                    @if ($product->complementaryProducts->isNotEmpty())
                    <details class="accordion-item" open>
                        <summary>
                            <span>Tamamlayıcı Ürünler</span>
                            <svg class="accordion-chevron w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </summary>
                        <div class="accordion-body">
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                @foreach ($product->complementaryProducts as $related)
                                <a href="{{ route('products.show', $related->slug) }}" class="card group block">
                                    @if ($related->image)
                                    <div class="aspect-square overflow-hidden bg-gray-50">
                                        <img src="{{ Storage::url($related->image) }}" alt="{{ $related->name }}"
                                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                    </div>
                                    @else
                                    <div class="aspect-square bg-gray-100"></div>
                                    @endif
                                    <div class="p-3">
                                        <p class="text-xs font-medium leading-snug" style="color: var(--color-navy);">{{ $related->name }}</p>
                                    </div>
                                </a>
                                @endforeach
                            </div>
                        </div>
                    </details>
                    @endif

                    {{-- 5. İlgili Projeler (açık, varsa — Brief §05 accordion sırası) --}}
                    @if ($product->referenceProjects->isNotEmpty())
                    <details class="accordion-item" open>
                        <summary>
                            <span>İlgili Projeler</span>
                            <svg class="accordion-chevron w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </summary>
                        <div class="accordion-body">
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                @foreach ($product->referenceProjects as $project)
                                <a href="{{ route('projects.show', $project->slug) }}" class="card group block overflow-hidden">
                                    @if ($project->image)
                                    <div class="aspect-video overflow-hidden">
                                        <img src="{{ Storage::url($project->image) }}" alt="{{ $project->title }}"
                                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                    </div>
                                    @else
                                    <div class="aspect-video bg-gray-100"></div>
                                    @endif
                                    <div class="p-3">
                                        <p class="text-xs font-medium leading-snug" style="color: var(--color-navy);">{{ $project->title }}</p>
                                        @if ($project->location)
                                        <p class="text-xs text-gray-400 mt-0.5">{{ $project->location }}</p>
                                        @endif
                                    </div>
                                </a>
                                @endforeach
                            </div>
                        </div>
                    </details>
                    @endif

                </div>
            </article>

            {{-- Sağ: %35 Sticky Sidebar --}}
            <aside class="lg:w-[35%] shrink-0">
                <div class="sticky top-[72px] space-y-4">

                    {{-- Birincil Aksiyonlar --}}
                    <div class="border border-gray-100 rounded-sm p-5 space-y-2">
                        <a href="{{ route('contact.index') }}?konu=teklif&urun={{ urlencode($product->name) }}"
                           class="btn btn-primary w-full justify-center">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Teklif İste
                        </a>
                        <a href="{{ route('contact.index') }}"
                           class="btn btn-secondary w-full justify-center">
                            Teknik Destek
                        </a>
                    </div>

                    {{-- Teknik Dokümanlar --}}
                    @if ($product->tds_file || $product->sds_file || $product->ce_file)
                    <div class="border border-gray-100 rounded-sm p-5">
                        <div class="label-caps mb-3">Teknik Dokümanlar</div>
                        <button onclick="openDocModal({{ $product->id }}, '{{ addslashes($product->name) }}', {{ \Illuminate\Support\Js::from($product->availableDocTypes()) }})"
                                class="w-full flex items-center gap-3 p-3 border border-gray-200 rounded-sm hover:border-navy transition-colors text-left group">
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-navy flex-shrink-0 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <div>
                                <div class="text-sm font-medium" style="color: var(--color-navy);">TDS / SDS / CE Talep Et</div>
                                <div class="text-xs text-gray-400 mt-0.5">
                                    @php $docs = array_filter(['TDS' => $product->tds_file, 'SDS' => $product->sds_file, 'CE' => $product->ce_file]); @endphp
                                    {{ implode(', ', array_keys($docs)) }} mevcut
                                </div>
                            </div>
                        </button>
                    </div>
                    @endif

                    {{-- Ambalaj bilgisi (Brief §05: "ambalaj bilgisi alt kısımda") --}}
                    @if (!empty($product->package_sizes))
                    <div class="border border-gray-100 rounded-sm p-5">
                        <div class="label-caps mb-3">Ambalaj Seçenekleri</div>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($product->package_sizes as $size)
                            <span class="border border-gray-200 rounded px-2.5 py-1 text-xs text-gray-700">{{ $size }}</span>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    {{-- Kategoriler --}}
                    @if ($product->categories->isNotEmpty())
                    <div class="border border-gray-100 rounded-sm p-5">
                        <div class="label-caps mb-3">Kategoriler</div>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($product->categories as $cat)
                            <a href="{{ route('products.index', $cat->segment->slug ?? '#') }}?kategori={{ $cat->id }}"
                               class="text-xs border border-gray-200 rounded px-2.5 py-1 text-gray-600 hover:text-navy hover:border-navy transition-colors">
                                {{ $cat->name }}
                            </a>
                            @endforeach
                        </div>
                    </div>
                    @endif

                </div>
            </aside>

        </div>
    </div>

    {{-- Mobil Sticky CTA Bandı (lg'de gizli) --}}
    <div class="fixed bottom-0 left-0 right-0 z-40 lg:hidden border-t border-gray-200 bg-white px-4 py-3 flex gap-2 shadow-lg">
        <a href="{{ route('contact.index') }}?konu=teklif&urun={{ urlencode($product->name) }}"
           class="btn btn-primary flex-1 justify-center text-sm py-2.5">
            Teklif İste
        </a>
        @if ($product->tds_file || $product->sds_file || $product->ce_file)
        <button onclick="openDocModal({{ $product->id }}, '{{ addslashes($product->name) }}', {{ \Illuminate\Support\Js::from($product->availableDocTypes()) }})"
                class="btn btn-secondary text-sm py-2.5 px-4">
            TDS/SDS/CE
        </button>
        @endif
        <a href="{{ route('contact.index') }}"
           class="btn btn-secondary text-sm py-2.5 px-4">
            Destek
        </a>
    </div>

</x-layouts.app>
