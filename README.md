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
of Hyde's route index, so `php hyde serve` returns 404 for them and for `/`. That is expected; they
exist in the compiled `_site/` output. To check them, run `php hyde build` and serve the result
statically with `php -S localhost:8000 -t _site`.

`php hyde build` does not fully empty `_site/` between runs — it removes only top-level `.html`/`.json`
files plus the media directory. If you are inspecting build output, run `rm -rf _site` first so stale
pages from an earlier build do not mislead you.
