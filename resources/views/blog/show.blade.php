<x-layouts.app :title="($post->meta_title ?: $post->title) . ' — Digalpa'"
               :description="$post->meta_description ?: $post->excerpt">

    <x-breadcrumb :items="['Blog' => route('blog.index'), $post->title => null]" />

    <div class="container-content py-10">
        <div class="flex flex-col lg:flex-row gap-12">

            {{-- Makale --}}
            <article class="lg:w-[65%] min-w-0">
                @if ($post->blogCategory)
                <div class="label-caps mb-4">{{ $post->blogCategory->name }}</div>
                @endif

                <h1 class="text-4xl lg:text-5xl mb-6">{{ $post->title }}</h1>

                <div class="flex items-center gap-4 text-sm text-gray-400 mb-8 pb-8 border-b border-gray-100">
                    <time>{{ $post->published_at->format('d M Y') }}</time>
                    @if ($post->author)
                    <span>·</span>
                    <span>{{ $post->author }}</span>
                    @endif
                </div>

                @if ($post->image)
                <div class="aspect-video overflow-hidden rounded-sm mb-10 bg-gray-100">
                    <img src="{{ Storage::url($post->image) }}" alt="{{ $post->title }}"
                         class="w-full h-full object-cover">
                </div>
                @endif

                @if ($post->excerpt)
                <p class="text-lg text-gray-600 leading-relaxed mb-8 font-medium">{{ $post->excerpt }}</p>
                @endif

                <div class="prose prose-sm max-w-none text-gray-700 leading-relaxed">
                    {!! $post->content !!}
                </div>
            </article>

            {{-- Sidebar --}}
            <aside class="lg:w-[35%] shrink-0">
                <div class="sticky top-[104px] space-y-4">

                    {{-- İçindekiler — JS ile doldurulur, başlık < 2 ise gizli kalır --}}
                    <div id="toc-card" class="border border-gray-100 rounded-sm p-5 hidden">
                        <div class="label-caps mb-3">İçindekiler</div>
                        <nav aria-label="İçindekiler">
                            <ul id="toc-list" class="space-y-0.5 border-l-2 border-gray-100 pl-3"></ul>
                        </nav>
                    </div>

                    {{-- İlgili Ürünler --}}
                    @if ($relatedProducts->isNotEmpty())
                    <div class="border border-gray-100 rounded-sm p-5">
                        <div class="label-caps mb-4">İlgili Ürünler</div>
                        <div class="space-y-3">
                            @foreach ($relatedProducts as $product)
                            @php
                                $colorKey = $product->categories->first()?->segment?->color_key ?? 'navy';
                            @endphp
                            <div class="border border-gray-100 rounded-sm overflow-hidden">
                                <div class="h-0.5 w-full" style="background-color: var(--color-{{ $colorKey }})"></div>
                                <div class="p-3">
                                    <p class="text-sm font-medium leading-snug mb-1" style="color: var(--color-navy)">
                                        {{ $product->name }}
                                    </p>
                                    @if ($product->short_description)
                                    <p class="text-xs text-gray-500 leading-relaxed mb-2 line-clamp-2">
                                        {{ $product->short_description }}
                                    </p>
                                    @endif
                                    <div class="flex items-center gap-3">
                                        <a href="{{ route('products.show', $product->slug) }}"
                                           class="text-xs font-medium transition-colors"
                                           style="color: var(--color-navy-60)">
                                            İncele →
                                        </a>
                                        @if ($product->tds_file || $product->sds_file || $product->ce_file)
                                        <button onclick="openDocModal({{ $product->id }}, '{{ addslashes($product->name) }}', {{ \Illuminate\Support\Js::from($product->availableDocTypes()) }})"
                                                class="text-xs text-gray-400 hover:text-gray-600 transition-colors ml-auto">
                                            Belge Talep Et
                                        </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    {{-- Belge Talebi Kartı --}}
                    <div class="rounded-sm p-5" style="background-color: var(--color-navy-10)">
                        <div class="label-caps mb-2">Teknik Doküman</div>
                        <p class="text-sm text-gray-600 leading-relaxed mb-3">
                            Ürünlerimize ait TDS ve SDS belgelerini e-posta ile talep edebilirsiniz.
                        </p>
                        <button onclick="openDocModal('', 'Teknik Doküman Talebi')"
                                class="btn btn-primary w-full justify-center text-sm py-2">
                            Doküman Talep Et
                        </button>
                    </div>

                    {{-- Benzer Yazılar --}}
                    @if ($relatedPosts->isNotEmpty())
                    <div class="border border-gray-100 rounded-sm p-5">
                        <div class="label-caps mb-4">Benzer Yazılar</div>
                        <div class="space-y-4">
                            @foreach ($relatedPosts as $related)
                            <a href="{{ route('blog.show', $related->slug) }}"
                               class="group flex gap-3 items-start">
                                @if ($related->image)
                                <div class="w-16 h-16 shrink-0 overflow-hidden rounded bg-gray-100">
                                    <img src="{{ Storage::url($related->image) }}" alt=""
                                         class="w-full h-full object-cover">
                                </div>
                                @endif
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium line-clamp-2 leading-snug transition-colors"
                                       style="color: var(--color-navy)">
                                        {{ $related->title }}
                                    </p>
                                    <p class="text-xs text-gray-400 mt-1">{{ $related->published_at->format('d M Y') }}</p>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>
                    @endif

                </div>
            </aside>

        </div>
    </div>

    <script>
    (function () {
        var article = document.querySelector('article');
        var tocCard = document.getElementById('toc-card');
        var tocList = document.getElementById('toc-list');
        if (!article || !tocList) return;

        var headings = Array.prototype.slice.call(article.querySelectorAll('h2, h3'));
        if (headings.length < 2) return;

        headings.forEach(function (h, i) {
            if (!h.id) h.id = 'toc-heading-' + i;

            var li = document.createElement('li');
            var a  = document.createElement('a');
            a.href        = '#' + h.id;
            a.textContent = h.textContent;
            a.dataset.tocId = h.id;
            a.className   = 'toc-link block py-1 text-gray-500 hover:text-navy transition-colors ' +
                (h.tagName === 'H3' ? 'pl-4 text-xs' : 'text-sm font-medium');

            a.addEventListener('click', function (e) {
                e.preventDefault();
                document.getElementById(h.id).scrollIntoView({ behavior: 'smooth', block: 'start' });
            });

            li.appendChild(a);
            tocList.appendChild(li);
        });

        tocCard.classList.remove('hidden');

        var links = Array.prototype.slice.call(tocList.querySelectorAll('.toc-link'));

        var observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (!entry.isIntersecting) return;
                links.forEach(function (l) {
                    l.classList.remove('text-navy');
                    l.style.fontWeight = '';
                });
                var active = tocList.querySelector('[data-toc-id="' + entry.target.id + '"]');
                if (active) {
                    active.classList.add('text-navy');
                    active.style.fontWeight = '600';
                }
            });
        }, { rootMargin: '-10% 0% -80% 0%', threshold: 0 });

        headings.forEach(function (h) { observer.observe(h); });
    }());
    </script>

</x-layouts.app>
