<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teknik Doküman Talebiniz</title>
    <style>
        body { font-family: 'DM Sans', Arial, sans-serif; color: #0B2545; background: #f9fafb; margin: 0; padding: 0; }
        .wrapper { max-width: 580px; margin: 32px auto; background: #ffffff; border: 1px solid #e5e7eb; border-radius: 4px; overflow: hidden; }
        .header { background: #0B2545; padding: 28px 32px; }
        .header-brand { color: #ffffff; font-size: 20px; font-weight: 400; letter-spacing: -0.01em; }
        .body { padding: 32px; }
        .greeting { font-size: 16px; margin-bottom: 16px; }
        .product-box { background: #f3f4f6; border-left: 3px solid #0B2545; padding: 14px 16px; border-radius: 2px; margin: 20px 0; }
        .product-box strong { display: block; font-size: 14px; color: #0B2545; margin-bottom: 4px; }
        .product-box span { font-size: 13px; color: #6b7280; }
        .doc-list { margin: 16px 0; padding-left: 20px; }
        .doc-list li { font-size: 14px; color: #374151; margin-bottom: 6px; }
        .text { font-size: 14px; color: #4b5563; line-height: 1.6; margin-bottom: 12px; }
        .divider { border: none; border-top: 1px solid #e5e7eb; margin: 24px 0; }
        .footer { padding: 20px 32px; background: #f9fafb; border-top: 1px solid #e5e7eb; }
        .footer p { font-size: 12px; color: #9ca3af; margin: 0; }
    </style>
</head>
<body>
    <div class="wrapper">

        <div class="header">
            <div class="header-brand">Digalpa Kimya</div>
        </div>

        <div class="body">
            <p class="greeting">Sayın {{ $request->full_name }},</p>

            <p class="text">
                Teknik doküman talebiniz için teşekkür ederiz.
                Talep ettiğiniz doküman(lar) bu e-postaya eklenmiştir.
            </p>

            <div class="product-box">
                <strong>{{ $request->product?->name ?? $request->product_name ?? '—' }}</strong>
                <span>
                    @php
                        $typeLabels = ['tds' => 'TDS — Teknik Veri Sayfası', 'sds' => 'SDS — Güvenlik Veri Sayfası', 'ce' => 'CE — Uygunluk Belgesi'];
                        $requested = explode(',', $request->document_type);
                    @endphp
                    {{ implode(' + ', array_intersect_key($typeLabels, array_flip($requested))) }}
                </span>
            </div>

            <p class="text">
                Ürün ve uygulama hakkında teknik destek almak için aşağıdaki kanallardan bize ulaşabilirsiniz.
            </p>

            <hr class="divider">

            <p class="text" style="font-size: 13px;">
                Saygılarımızla,<br>
                <strong>Digalpa Kimya Sanayi A.Ş.</strong>
            </p>
        </div>

        <div class="footer">
            <p>Bu e-posta {{ config('app.url') }} üzerinden yapılan doküman talebi nedeniyle gönderilmiştir.</p>
        </div>

    </div>
</body>
</html>
