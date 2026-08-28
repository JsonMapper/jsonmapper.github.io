# JsonMapper.net

This repository contains the source code for the [JsonMapper.net](https://jsonmapper.net) website.
For the JsonMapper package, see the [JsonMapper/JsonMapper](https://github.com/JsonMapper/JsonMapper) repository.

The site is built with [HydePHP](https://hydephp.com), a static site generator built on Laravel Zero.
The documentation is plain Markdown in `_docs/`; Hyde's documentation module provides the layout,
sidebar, search, table of contents and dark mode, so there is no custom layout or stylesheet to
maintain.

## Local Development

Requirements:

- PHP 8.2 or higher
- [Composer](https://getcomposer.org)

Node.js is *not* required. Hyde ships a precompiled stylesheet and this site uses the stock theme.

```shell
# Install dependencies.
composer install

# Serve the site with live recompilation on http://localhost:8080
php hyde serve

# Compile the site into _site/
php hyde build

# List every page and where it will be written.
php hyde route:list
```

## Adding a documentation page

Create a Markdown file under `_docs/<section>/<page>.md` with a title:

```yaml
---
title: Rename
---
```

The subdirectory becomes the sidebar group. Do not set `permalink` or `layout` — Hyde derives routes
from the file path. Ordering and labels live in `config/docs.php` under `sidebar.order` and
`sidebar.labels`, keyed by page identifier (the path below `_docs/` without the extension).

Documentation output is flat, so `_docs/usage/installation.md` is served at `/docs/installation`.

## Code examples

The package these pages document lives in
[JsonMapper/JsonMapper](https://github.com/JsonMapper/JsonMapper), so nothing in this repo compiles the
examples. A broken snippet renders perfectly and ships. Two conventions and one CI check keep that in
hand.

**Write class names out in full; do not add an import block.** A snippet is usually a dozen lines, and
five lines of `use` above it costs more than the width does:

```php
$mapper = (new \JsonMapper\JsonMapperFactory())->default();
$mapper->push(new \JsonMapper\Middleware\CaseConversion(
    \JsonMapper\Enums\TextNotation::STUDLY_CAPS(),
    \JsonMapper\Enums\TextNotation::CAMEL_CASE()
));
```

The exception is a snippet standing in for a real file in the reader's application — one that declares
its own `namespace`. Those use imports, because that is what the reader would write.

**Let the example define the classes it maps onto.** Do not reference the package's test fixtures; a
reader copying `\JsonMapper\Tests\Implementation\SimpleObject` gets a class their project does not
have. Three lines of `class User { public string $name; }` is enough.

**Note the introducing release only for APIs added during 2.x**, as `_Available since JsonMapper
x.y.z_` under the page intro. The site documents v2, so "available since 0.3.0" answers a question
nobody has.

`.github/workflows/lint-examples.yml` checks every ` ```php ` block on each pull request, in two
passes. Run them locally with:

```shell
$PHP .github/scripts/lint-code-examples.php                              # 1. parse
$PHP .github/scripts/extract-code-examples.php .phpstan-doc-examples     # 2. analyse
$PHP vendor/bin/phpstan analyse -c .github/phpstan.neon --memory-limit=512M .phpstan-doc-examples
```

The first is a parse check needing only a PHP binary. The second runs PHPStan against the real
`json-mapper/json-mapper`, which is a dev dependency here for exactly that reason, and is what catches
a call to a method that does not exist, a missing constructor argument, or an argument of the wrong
type. Both report against the markdown file and line: the extractor blanks out everything that is not
code rather than collapsing it, so an analysed file's line numbers are the page's line numbers.

Examples are extracted **per page**, since a page routinely defines a class in one fence and maps onto
it in the next, and each page is given its own namespace so that the `User` several pages define does
not collide. A fence that declares its own `namespace` is analysed as its own file.

Classes the examples borrow from the reader's imagination (`\App\…`) or from packages that cannot be
installed alongside Hyde are declared in `.github/stubs/placeholders.php`. Prefer a real dev dependency
over a stub where the two can coexist — `json-mapper/laravel-package` and `monolog/monolog` are
installed for this reason, so those pages are checked against the genuine classes.

Neither pass runs the examples, so a snippet that is valid and well-typed but throws at run time still
gets through — `(new JsonMapperFactory())->create()` with no middleware is the case that motivated
this. Before changing a snippet, check it against a real checkout of JsonMapper and make the inline
`// "John Doe"` comments the output it genuinely produces.

## Deployment

Pushing to `main` triggers `.github/workflows/build.yml`, which builds the site and publishes it to
GitHub Pages. The compiled `_site/` directory is not committed.

URLs from before the migration from Jekyll are kept alive by redirect pages generated in
`app/Actions/GenerateRedirectsBuildTask.php`. If you rename or move a documentation page, add the old
path there.

## Troubleshooting

`php hyde serve` starts PHP's built-in server as a child process using whichever `php` is on your
`PATH`. Invoking Hyde with an explicit 8.2 binary is not enough — if `php` resolves to an older
version the server returns HTTP 500 with a Composer platform check error. Put the right PHP on your
`PATH` first:

```shell
export PATH=/usr/local/Cellar/php@8.2/8.2.27/bin:$PATH
php hyde serve
```

The redirect pages that preserve the pre-migration URLs are generated after the build and are not part
of Hyde's route index, so `php hyde serve` returns 404 for them. That is expected; they exist in the
compiled `_site/` output. To check them, run `php hyde build` and serve the result statically with
`php -S localhost:8000 -t _site`.

The site root is not one of them. `/` is the landing page, a Blade page at
`_pages/index.blade.php`, so it resolves under `hyde serve` too. Its code sample lives in
`resources/includes/home-example.md` and is rendered through the Markdown pipeline so it picks up the
same highlighting as the documentation. Note that a multi-line `@php` block cannot be combined with the
single-line `@php($title = ...)` front matter directive in that file: Blade emits an unterminated
opening tag and the page fails to render.

Presentation on that page uses utilities already present in the precompiled `_media/app.css`, plus a
small scoped `<style>` block for what it lacks (the yellow accent, responsive columns, a couple of
radii). Check a class exists in that file before using it — there is no Tailwind build to add one.

`php hyde build` does not fully empty `_site/` between runs — it removes only top-level `.html`/`.json`
files plus the media directory. If you are inspecting build output, run `rm -rf _site` first so stale
pages from an earlier build do not mislead you.

## Sponsoring
[![JetBrains logo.](https://resources.jetbrains.com/storage/products/company/brand/logos/jetbrains.svg)](https://jb.gg/OpenSource)
