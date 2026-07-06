<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bakım Çalışması — Digalpa</title>
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32'><rect width='32' height='32' rx='5' fill='%230B2545'/><text x='16' y='23' font-family='Georgia,serif' font-size='20' font-weight='bold' fill='white' text-anchor='middle'>D</text></svg>">
    @vite(['resources/css/app.css'])
</head>
<body class="bg-white min-h-screen flex flex-col">

    {{-- Nav şeridi --}}
    <div class="h-14 shrink-0 flex items-center px-8" style="background-color: var(--color-navy);">
        <span class="font-serif text-white text-xl tracking-tight">Digalpa</span>
    </div>

    {{-- İçerik --}}
    <main class="flex-1 flex items-center justify-center px-6 py-20">
        <div class="text-center max-w-md">

            {{-- Animasyonlu ikon --}}
            <div class="w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-8"
                 style="background-color: var(--color-navy-10);">
                <svg class="w-9 h-9" style="color: var(--color-navy);" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l5.654-4.654m5.664-1.519l4.16-4.16a.75.75 0 011.06 1.06l-4.16 4.16"/>
                </svg>
            </div>

            <div class="label-caps mb-4" style="color: var(--color-navy-40);">Bakım Modu</div>

            <h1 class="text-2xl mb-4" style="color: var(--color-navy);">
                Kısa süre içinde geri döneceğiz
            </h1>

            <p class="text-gray-500 leading-relaxed mb-8">
                Siteyi daha iyi hale getirmek için bakım çalışması yapıyoruz.
                Anlayışınız için teşekkür ederiz.
            </p>

            @if (isset($exception) && $exception->getMessage())
            <p class="text-xs text-gray-400 mt-4">{{ $exception->getMessage() }}</p>
            @endif

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
