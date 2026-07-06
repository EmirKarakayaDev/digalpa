<x-layouts.app title="Referans Projeler — Digalpa">

    <x-breadcrumb :items="['Referans Projeler' => null]" />

    <div class="container-content py-10">
        <div class="mb-10">
            <div class="label-caps mb-2">Referanslar</div>
            <h1 class="text-4xl">Tamamlanan Projeler</h1>
        </div>

        {{-- Filtreler: Segment + Kaynak --}}
        <div class="flex flex-col sm:flex-row sm:items-center gap-3 mb-8">

            {{-- Segment filtresi --}}
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('projects.index', array_filter(['kaynak' => $activeSource])) }}"
                   class="text-sm border rounded px-3 py-1.5 transition-colors {{ !$activeSegment ? 'border-navy bg-navy text-white' : 'border-gray-200 text-gray-600 hover:border-navy hover:text-navy' }}">
                    Tüm Segmentler
                </a>
                @foreach ($segments as $segment)
                <a href="{{ route('projects.index', array_filter(['segment' => $segment->slug, 'kaynak' => $activeSource])) }}"
                   class="text-sm border rounded px-3 py-1.5 transition-colors {{ $activeSegment?->id === $segment->id ? 'border-navy bg-navy text-white' : 'border-gray-200 text-gray-600 hover:border-navy hover:text-navy' }}">
                    {{ $segment->name }}
                </a>
                @endforeach
            </div>

            <div class="hidden sm:block w-px h-6 bg-gray-200 mx-1"></div>

            {{-- Kaynak filtresi --}}
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('projects.index', array_filter(['segment' => $activeSegment?->slug])) }}"
                   class="text-sm border rounded px-3 py-1.5 transition-colors {{ !$activeSource ? 'border-navy bg-navy text-white' : 'border-gray-200 text-gray-600 hover:border-navy hover:text-navy' }}">
                    Tümü
                </a>
                <a href="{{ route('projects.index', array_filter(['segment' => $activeSegment?->slug, 'kaynak' => 'digalpa'])) }}"
                   class="text-sm border rounded px-3 py-1.5 transition-colors {{ $activeSource === 'digalpa' ? 'border-navy bg-navy text-white' : 'border-gray-200 text-gray-600 hover:border-navy hover:text-navy' }}">
                    Digalpa
                </a>
                <a href="{{ route('projects.index', array_filter(['segment' => $activeSegment?->slug, 'kaynak' => 'akemi'])) }}"
                   class="text-sm border rounded px-3 py-1.5 transition-colors {{ $activeSource === 'akemi' ? 'border-[#A55182] bg-[#A55182] text-white' : 'border-gray-200 text-gray-600 hover:border-[#A55182] hover:text-[#A55182]' }}">
                    AKEMI Referans
                </a>
            </div>
        </div>

        @if ($projects->isEmpty())
        <p class="text-gray-500 py-10">Henüz proje eklenmemiş.</p>
        @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($projects as $project)
            <a href="{{ route('projects.show', $project->slug) }}"
               class="card group block overflow-hidden {{ $project->source === 'akemi' ? 'card-akemi' : '' }}">
                @if ($project->image)
                <div class="aspect-video overflow-hidden">
                    <img src="{{ Storage::url($project->image) }}" alt="{{ $project->title }}"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                </div>
                @else
                <div class="aspect-video bg-gray-100"></div>
                @endif
                <div class="p-5">
                    <div class="flex items-center gap-2 flex-wrap">
                        @if ($project->segment)
                        <x-segment-badge :segment="$project->segment" />
                        @endif
                        @if ($project->source === 'akemi')
                        <span class="badge-akemi">AKEMI Referans</span>
                        @endif
                    </div>
                    <h3 class="mt-3 font-medium leading-snug transition-colors" style="color: var(--color-navy);">
                        {{ $project->title }}
                    </h3>
                    <div class="mt-1 flex items-center gap-2 text-xs text-gray-400 flex-wrap">
                        @if ($project->client)<span>{{ $project->client }}</span>@endif
                        @if ($project->client && $project->location)<span>·</span>@endif
                        @if ($project->location)<span>{{ $project->location }}</span>@endif
                        @if ($project->year)<span>· {{ $project->year }}</span>@endif
                    </div>
                    @if ($project->description)
                    <p class="text-sm text-gray-500 mt-2 line-clamp-2">{{ $project->description }}</p>
                    @endif
                </div>
            </a>
            @endforeach
        </div>

        @if ($projects->hasPages())
        <div class="mt-10">
            {{ $projects->links() }}
        </div>
        @endif
        @endif
    </div>

</x-layouts.app>
