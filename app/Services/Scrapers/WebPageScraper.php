<?php

namespace App\Services\Scrapers;

use Illuminate\Support\Facades\Http;

class WebPageScraper
{
    public function fetch(string $url): array
    {
        $html = Http::timeout(30)->get($url)->throw()->body();

        return [
            'html' => $html,
            'text' => $this->extractText($html),
        ];
    }

    private function extractText(string $html): string
    {
        $html = preg_replace('#<(script|style)[^>]*>.*?</\1>#is', ' ', $html) ?? $html;
        $html = strip_tags($html);

        return trim(preg_replace('/\s+/u', ' ', html_entity_decode($html, ENT_QUOTES | ENT_HTML5, 'UTF-8')) ?? '');
    }
}
