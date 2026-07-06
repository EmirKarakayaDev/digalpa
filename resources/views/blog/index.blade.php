<x-layouts.app title="Blog — Digalpa">

    <x-breadcrumb :items="['Blog' => null]" />

    <div class="container-content py-10">
        <div class="mb-10">
            <div class="label-caps mb-2">Blog</div>
            <h1 class="text-4xl">Teknik Yazılar</h1>
        </div>

        <div class="flex flex-col lg:flex-row gap-10">

            {{-- Kategori filtresi --}}
            <aside class="lg:w-52 shrink-0">
                <div class="label-caps mb-3">Kategoriler</div>
                <ul class="space-y-1">
                    <li>
                        <a href="{{ route('blog.index') }}"
                           class="block text-sm py-1.5 px-2 rounded transition-colors {{ !$activeCategory ? 'text-navy font-medium bg-navy-10' : 'text-gray-600 hover:text-navy' }}">
                            Tümü
                        </a>
                    </li>
                    @foreach ($categories as $cat)
                    <li>
                        <a href="?kategori={{ $cat->slug }}"
                           class="flex items-center justify-between text-sm py-1.5 px-2 rounded transition-colors {{ $activeCategory?->id === $cat->id ? 'text-navy font-medium bg-navy-10' : 'text-gray-600 hover:text-navy' }}">
                            <span>{{ $cat->name }}</span>
                            <span class="text-xs text-gray-400">{{ $cat->posts_count }}</span>
                        </a>
                    </li>
                    @endforeach
                </ul>
            </aside>

            {{-- Yazı listesi --}}
            <div class="flex-1 min-w-0">
                @if ($posts->isEmpty())
                <p class="text-gray-500 py-10">Henüz yazı yok.</p>
                @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($posts as $post)
                    <a href="{{ route('blog.show', $post->slug) }}" class="group block">
                        @if ($post->image)
                        <div class="aspect-video overflow-hidden rounded-sm mb-4 bg-gray-100">
                            <img src="{{ Storage::url($post->image) }}" alt="{{ $post->title }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        </div>
                        @else
                        <div class="aspect-video bg-gray-100 rounded-sm mb-4"></div>
                        @endif

                        @if ($post->blogCategory)
                        <div class="label-caps text-navy-40 mb-1">{{ $post->blogCategory->name }}</div>
                        @endif

                        <h3 class="font-medium text-navy leading-snug group-hover:text-navy-60 transition-colors">
                            {{ $post->title }}
                        </h3>

                        @if ($post->excerpt)
                        <p class="text-sm text-gray-500 mt-2 line-clamp-3">{{ $post->excerpt }}</p>
                        @endif

                        <div class="mt-3 text-xs text-gray-400">
                            {{ $post->published_at->format('d M Y') }}
                            @if ($post->author) · {{ $post->author }} @endif
                        </div>
                    </a>
                    @endforeach
                </div>

                @if ($posts->hasPages())
                <div class="mt-10">
                    {{ $posts->links() }}
                </div>
                @endif
                @endif
            </div>

        </div>
    </div>

</x-layouts.app>
