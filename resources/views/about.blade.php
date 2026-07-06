<x-layouts.app title="Hakkımızda — Digalpa Kimya Sanayi A.Ş."
               description="Digalpa Kimya Sanayi A.Ş. hakkında bilgi edinin.">

    <x-breadcrumb :items="['Hakkımızda' => null]" />

    <div class="container-content py-20">

        <div class="max-w-3xl">
            <div class="label-caps mb-3">Kurumsal</div>
            <h1 class="mb-6">Digalpa Kimya<br><em>Sanayi A.Ş.</em></h1>
            <p class="text-gray-600 leading-relaxed text-lg mb-8">
                {{ $about['about.intro'] }}
            </p>
            <p class="text-gray-600 leading-relaxed mb-8">
                {{ $about['about.body'] }}
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-16 pt-16 border-t border-gray-100">
            <div>
                <div class="text-4xl font-semibold mb-2" style="color: var(--color-navy);">{{ $about['about.stat1_value'] }}</div>
                <div class="text-gray-500 text-sm">{{ $about['about.stat1_label'] }}</div>
            </div>
            <div>
                <div class="text-4xl font-semibold mb-2" style="color: var(--color-navy);">{{ $about['about.stat2_value'] }}</div>
                <div class="text-gray-500 text-sm">{{ $about['about.stat2_label'] }}</div>
            </div>
            <div>
                <div class="text-4xl font-semibold mb-2" style="color: var(--color-navy);">{{ $about['about.stat3_value'] }}</div>
                <div class="text-gray-500 text-sm">{{ $about['about.stat3_label'] }}</div>
            </div>
        </div>

        <div class="mt-16">
            <a href="{{ route('contact.index') }}" class="btn btn-primary">İletişime Geç</a>
        </div>

    </div>

</x-layouts.app>
