<?php

namespace App\Services\AI;

use Illuminate\Support\Facades\File;
use InvalidArgumentException;

class PromptService
{
    public function get(string $name, array $variables = []): string
    {
        $path = resource_path("prompts/{$name}.md");

        if (! File::exists($path)) {
            throw new InvalidArgumentException("Prompt file not found: {$name}");
        }

        $prompt = File::get($path);

        foreach ($variables as $key => $value) {
            $prompt = str_replace('{{'.$key.'}}', (string) $value, $prompt);
        }

        return $prompt;
    }
}
