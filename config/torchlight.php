<?php

/*
|--------------------------------------------------------------------------
| Torchlight Syntax Highlighting
|--------------------------------------------------------------------------
|
| Torchlight highlights code blocks at build time through an HTTP API, and is
| what replaced the Rouge highlighting the site had under Jekyll.
|
| Hyde only activates it when a token is present (see Features::hasTorchlight),
| so without TORCHLIGHT_TOKEN the site still builds, but every code block
| renders as unhighlighted plain text.
|
| Only the keys set here override the package defaults, which are merged in by
| TorchlightServiceProvider.
|
*/

return [
    'token' => env('TORCHLIGHT_TOKEN'),

    /*
    | Monokai is the theme the Jekyll site used for dark mode, kept here so
    | code blocks look the way readers are used to.
    |
    | Torchlight can render a light and a dark theme together by passing an
    | array, but it then emits both blocks and leaves you to hide one in CSS.
    | Hyde's stylesheet has no rules for that, so this stays a single theme
    | until that CSS is written.
    */
    'theme' => env('TORCHLIGHT_THEME', 'monokai'),

    'options' => [
        'lineNumbers' => false,
    ],
];
