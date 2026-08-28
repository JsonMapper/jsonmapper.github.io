<?php

/*
|--------------------------------------------------------------------------
| Documentation Module Settings
|--------------------------------------------------------------------------
|
| Since the Hyde documentation module has many configuration options,
| they have now been broken out into their own configuration file.
|
*/

return [

    /*
    |--------------------------------------------------------------------------
    | Sidebar Settings
    |--------------------------------------------------------------------------
    |
    | The Hyde Documentation Module comes with a fancy Sidebar that is
    | automatically populated with links to your documentation pages.
    | Here, you can configure its behavior, content, look and feel.
    |
    */

    'sidebar' => [
        // The title in the sidebar header
        'header' => env('SITE_NAME', 'JsonMapper').' Docs',

        // When using a grouped sidebar, should the groups be collapsible?
        'collapsible' => true,

        // A string of Markdown to show in the footer. Set to `false` to disable.
        'footer' => '[GitHub](https://github.com/JsonMapper/JsonMapper) &middot; [Twitter](https://twitter.com/JsonMapper)',

        /*
        |--------------------------------------------------------------------------
        | Sidebar Page Order
        |--------------------------------------------------------------------------
        |
        | In the generated Documentation pages the navigation links in the sidebar
        | default to sort alphabetically. You can reorder the page identifiers
        | in the list below, and the links will get sorted in that order.
        |
        | The items will get a priority of 500 plus the order its found in the list.
        | Pages without a priority will fall back to the default priority of 999.
        |
        | You can also set explicit priorities in front matter or by specifying
        | a value to the array key in the list to override the inferred value.
        |
        */

        'order' => [
            // This list reproduces the section order of the old Jekyll
            // _data/menu.yml. Keys are page identifiers (the source path
            // relative to _docs, without the extension). Groups inherit the
            // priority of their highest-placed member, so listing the pages
            // in order also orders the groups.

            // General
            'index',
            'architecture',

            // Usage
            'usage/installation',
            'usage/setup',

            // Guides
            'guides/getting-started',
            'guides/creating-middleware',
            'guides/laravel-usage',
            'guides/symfony-usage',

            // Middleware
            'middleware/typed-properties',
            'middleware/doc-block-annotations',
            'middleware/namespace-resolver',
            'middleware/constructor',
            'middleware/case-conversion',
            'middleware/debugging',
            'middleware/final-callback',
            'middleware/rename',
            'middleware/value-transformation',
            'middleware/attributes',
            'middleware/laravel-eloquent',

            // Advanced Usage
            'advanced-usage/performance',
            'advanced-usage/casting-values',
            'advanced-usage/interfaces',
            'advanced-usage/abstracts',
        ],

        /*
        |--------------------------------------------------------------------------
        | Sidebar Labels
        |--------------------------------------------------------------------------
        |
        | Define custom labels for sidebar items. The array key should be the
        | page identifier, and the value should be the display label.
        |
        */

        'labels' => [
            \Hyde\Pages\DocumentationPage::homeRouteName() => 'Documentation',

            // Group headings, matching the old _data/menu.yml sections.
            'general' => 'General',
            'usage' => 'Usage',
            'guides' => 'Guides',
            'middleware' => 'Middleware',
            'advanced-usage' => 'Advanced Usage',

            // Pages whose menu label differed from the page title.
            'guides/laravel-usage' => 'Laravel Usage',
            'guides/symfony-usage' => 'Symfony Usage',
            'middleware/constructor' => 'Constructor support',
            'middleware/value-transformation' => 'Value transformation',
            'middleware/attributes' => 'PHP Attributes',
        ],

        /*
        |--------------------------------------------------------------------------
        | Table of Contents Settings
        |--------------------------------------------------------------------------
        |
        | The Hyde Documentation Module comes with a fancy Sidebar that, by default,
        | has a Table of Contents included. Here, you can configure its behavior,
        | content, look and feel. You can also disable the feature completely.
        |
        */

        'table_of_contents' => [
            'enabled' => true,
            'min_heading_level' => 2,
            'max_heading_level' => 4,
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Collaborative Source Editing Location
    |--------------------------------------------------------------------------
    |
    | @see https://hydephp.com/docs/2.x/documentation-pages#automatic-edit-page-button
    |
    | By adding a base URL here, Hyde will use it to create "edit source" links
    | to your documentation pages. Hyde expects this to be a GitHub path, but
    | it will probably work with other methods as well, if not, send a PR!
    |
    | You can also change the link text with the `edit_source_link_text` setting.
    |
    | Example: https://github.com/hydephp/docs/blob/master
    |          Do not specify the filename or extension, Hyde will do that for you.
    |          Setting this to null will disable the feature.
    |
    */

    'source_file_location_base' => 'https://github.com/JsonMapper/jsonmapper.github.io/blob/main/_docs',
    'edit_source_link_text' => 'Edit Source',
    'edit_source_link_position' => 'footer', // 'header', 'footer', or 'both'

    /*
    |--------------------------------------------------------------------------
    | Search Customization
    |--------------------------------------------------------------------------
    |
    | Hyde comes with an easy to use search feature for documentation pages.
    | @see https://hydephp.com/docs/2.x/documentation-pages#search-feature
    |
    */

    // Should a docs/search.html page be generated?
    'create_search_page' => true,

    // Are there any pages you don't want to show in the search results?
    'exclude_from_search' => [
        'changelog',
    ],

    /*
    |--------------------------------------------------------------------------
    | Flattened Output Paths
    |--------------------------------------------------------------------------
    |
    | If this setting is set to true, Hyde will output all documentation pages
    | into the same configured documentation output directory. This means
    | that you can use the automatic directory based grouping feature,
    | but still have a "flat" output structure. Note that this means
    | that you can't have two documentation pages with the same
    | filename or navigation menu label as they will overwrite each other.
    |
    | If you set this to false, Hyde will match the directory structure
    | of the source files (just like all other pages).
    |
    */

    'flattened_output_paths' => true,
];
