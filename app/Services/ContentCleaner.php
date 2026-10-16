<?php

namespace App\Services;

use Illuminate\Support\Str;

class ContentCleaner
{
    public function clean(string $html): string
    {
        $html = preg_replace('#<(script|style)[^>]*>.*?</\1>#is', ' ', $html) ?? $html;
        $html = preg_replace('/<!--.*?-->/s', ' ', $html) ?? $html;
        $html = html_entity_decode($html, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $text = strip_tags($html);
        $text = preg_replace('/\s+/u', ' ', $text) ?? $text;

        return trim(Str::of($text)->replace(["\r", "\n", "\t"], ' ')->squish()->toString());
    }
}
