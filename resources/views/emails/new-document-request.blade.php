<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yeni Doküman Talebi</title>
    <style>
        body { font-family: 'DM Sans', Arial, sans-serif; color: #0B2545; background: #f9fafb; margin: 0; padding: 0; }
        .wrapper { max-width: 580px; margin: 32px auto; background: #ffffff; border: 1px solid #e5e7eb; border-radius: 4px; overflow: hidden; }
        .header { background: #0B2545; padding: 28px 32px; }
        .header-brand { color: #ffffff; font-size: 20px; font-weight: 400; letter-spacing: -0.01em; }
        .body { padding: 32px; }
        .text { font-size: 14px; color: #4b5563; line-height: 1.6; margin-bottom: 12px; }
        table.details { width: 100%; border-collapse: collapse; margin: 20px 0; }
        table.details td { font-size: 14px; padding: 8px 0; border-bottom: 1px solid #f3f4f6; vertical-align: top; }
        table.details td:first-child { color: #9ca3af; width: 130px; }
        table.details td:last-child { color: #0B2545; font-weight: 500; }
        .cta { display: inline-block; margin-top: 8px; background: #0B2545; color: #ffffff; text-decoration: none; padding: 10px 20px; border-radius: 2px; font-size: 14px; }
        .footer { padding: 20px 32px; background: #f9fafb; border-top: 1px solid #e5e7eb; }
        .footer p { font-size: 12px; color: #9ca3af; margin: 0; }
    </style>
</head>
<body>
    <div class="wrapper">

        <div class="header">
            <div class="header-brand">Digalpa Kimya — Yeni Talep</div>
        </div>

        <div class="body">
            <p class="text">Web sitesinden yeni bir teknik doküman talebi geldi. 24 saat içinde yanıtlanması gerekiyor.</p>

            <table class="details">
                <tr><td>Ürün</td><td>{{ $request->product?->name ?? '—' }}</td></tr>
                <tr><td>Ad Soyad</td><td>{{ $request->full_name }}</td></tr>
                <tr><td>Firma</td><td>{{ $request->company ?: '—' }}</td></tr>
                <tr><td>E-posta</td><td>{{ $request->email }}</td></tr>
                <tr><td>Telefon</td><td>{{ $request->phone ?: '—' }}</td></tr>
                <tr><td>Belge Türü</td><td>{{ strtoupper(str_replace(',', ' + ', $request->document_type)) }}</td></tr>
                @if ($request->message)
                <tr><td>Not</td><td>{{ $request->message }}</td></tr>
                @endif
            </table>

            <a href="{{ config('app.url') }}/admin/document-requests/{{ $request->id }}/edit" class="cta">Talebi Panelde Aç</a>
        </div>

        <div class="footer">
            <p>Bu e-posta {{ config('app.url') }} üzerinden gelen bir doküman talebi nedeniyle otomatik gönderilmiştir.</p>
        </div>

    </div>
</body>
</html>
