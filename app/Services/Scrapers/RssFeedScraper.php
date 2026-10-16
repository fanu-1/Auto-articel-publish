<?php

namespace App\Services\Scrapers;

use Illuminate\Support\Facades\Http;
use SimpleXMLElement;

class RssFeedScraper
{
    public function fetch(string $url): array
    {
        $feed = Http::timeout(30)->get($url)->throw()->body();
        $xml = new SimpleXMLElement($feed);
        $channel = $xml->channel ?? null;

        if (! $channel) {
            return [];
        }

        $items = [];

        foreach ($channel->item as $item) {
            $items[] = [
                'title' => (string) $item->title,
                'url' => (string) $item->link,
                'excerpt' => trim((string) ($item->description ?? '')),
                'content' => trim((string) ($item->description ?? '')),
                'published_at' => (string) ($item->pubDate ?? ''),
            ];
        }

        return $items;
    }
}
