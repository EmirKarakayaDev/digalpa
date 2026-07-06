<?php

use App\Models\StaticTranslate;
use Illuminate\Support\Facades\Cache;

if (! function_exists('staticTranslate')) {
    /**
     * Veritabanındaki static_translates tablosundan çeviri döndürür.
     * Bulunamazsa key'i döndürür.
     */
    function staticTranslate(string $key, string $locale = null, string $default = null): string
    {
        $locale ??= app()->getLocale();

        $value = Cache::remember("st.{$locale}.{$key}", 3600, function () use ($key, $locale) {
            return StaticTranslate::where('key', $key)
                ->where('locale', $locale)
                ->value('value');
        });

        return $value ?? $default ?? $key;
    }
}

if (! function_exists('word_limiter')) {
    /**
     * Metni kelime sayısına göre kırpar.
     */
    function word_limiter(string $str, int $limit = 30, string $end = '…'): string
    {
        $words = preg_split('/\s+/', trim(strip_tags($str)));

        if (count($words) <= $limit) {
            return $str;
        }

        return implode(' ', array_slice($words, 0, $limit)) . $end;
    }
}

if (! function_exists('tgBbCode')) {
    /**
     * Basit BBCode → HTML dönüştürücü.
     * Desteklenen etiketler: [b], [i], [u], [s], [url], [color], [size], [br]
     */
    function tgBbCode(string $str): string
    {
        $patterns = [
            '/\[b\](.*?)\[\/b\]/is'               => '<strong>$1</strong>',
            '/\[i\](.*?)\[\/i\]/is'               => '<em>$1</em>',
            '/\[u\](.*?)\[\/u\]/is'               => '<u>$1</u>',
            '/\[s\](.*?)\[\/s\]/is'               => '<s>$1</s>',
            '/\[url=(.*?)\](.*?)\[\/url\]/is'     => '<a href="$1" target="_blank" rel="noopener">$2</a>',
            '/\[url\](.*?)\[\/url\]/is'           => '<a href="$1" target="_blank" rel="noopener">$1</a>',
            '/\[color=(.*?)\](.*?)\[\/color\]/is' => '<span style="color:$1">$2</span>',
            '/\[size=(\d+)\](.*?)\[\/size\]/is'   => '<span style="font-size:$1px">$2</span>',
            '/\[br\]/i'                            => '<br>',
        ];

        return preg_replace(array_keys($patterns), array_values($patterns), $str);
    }
}
