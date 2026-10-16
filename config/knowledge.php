<?php

return [
    'auto_publish' => (bool) env('PUBLISHING_AUTO_PUBLISH', false),
    'default_word_target' => (int) env('PUBLISHING_DEFAULT_WORD_TARGET', 1400),
    'default_tone' => env('PUBLISHING_DEFAULT_TONE', 'knowledge-first'),
];
