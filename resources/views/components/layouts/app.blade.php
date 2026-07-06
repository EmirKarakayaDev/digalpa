<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Digalpa Kimya Sanayi A.Ş.' }}</title>
    <meta name="description" content="{{ $description ?? 'İnşaat kimyasalları ve doğal taş koruma ürünleri.' }}">
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32'><rect width='32' height='32' rx='5' fill='%230B2545'/><text x='16' y='23' font-family='Georgia,serif' font-size='20' font-weight='bold' fill='white' text-anchor='middle'>D</text></svg>">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white min-h-screen flex flex-col">

    <x-navigation />

    <main class="flex-1">
        {{ $slot }}
    </main>

    <x-footer />

    <x-document-request-modal />

</body>
</html>
