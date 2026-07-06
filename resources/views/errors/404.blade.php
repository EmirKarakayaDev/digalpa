<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sayfa Bulunamadı — Digalpa</title>
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32'><rect width='32' height='32' rx='5' fill='%230B2545'/><text x='16' y='23' font-family='Georgia,serif' font-size='20' font-weight='bold' fill='white' text-anchor='middle'>D</text></svg>">
    @vite(['resources/css/app.css'])
</head>
<body class="bg-white min-h-screen flex flex-col">

    {{-- Nav şeridi --}}
    <div class="h-14 shrink-0 flex items-center px-8" style="background-color: var(--color-navy);">
        <a href="/" class="font-serif text-white text-xl tracking-tight">Digalpa</a>
    </div>

    {{-- İçerik --}}
    <main class="flex-1 flex items-center justify-center px-6 py-20">
        <div class="text-center max-w-md">

            <div class="font-serif text-[120px] leading-none font-semibold mb-2"
                 style="color: var(--color-navy-10);">404</div>

            <div class="label-caps mb-4" style="color: var(--color-navy-40);">Sayfa Bulunamadı</div>

            <h1 class="text-2xl mb-4" style="color: var(--color-navy);">
                Bu sayfayı bulamadık
            </h1>

            <p class="text-gray-500 leading-relaxed mb-8">
                Aradığınız sayfa kaldırılmış, taşınmış ya da URL hatalı yazılmış olabilir.
            </p>

            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                <a href="/" class="btn btn-primary">Ana Sayfaya Dön</a>
                <a href="/urun-bulucu" class="btn btn-secondary">Ürün Bulucu</a>
            </div>

        </div>
    </main>

    {{-- Footer şeridi --}}
    <div class="py-5 text-center border-t border-gray-100">
        <p class="text-xs text-gray-400">
            &copy; {{ date('Y') }} Digalpa Kimya Sanayi A.Ş.
        </p>
    </div>

</body>
</html>
