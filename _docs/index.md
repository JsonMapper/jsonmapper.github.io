---
title: Documentation
navigation:
    group: General
---

# Documentation

JsonMapper maps JSON data to PHP classes through a chain of middleware that you arrange to suit your
own models. These pages cover installing it, the middleware it ships with, and how to extend it.

New here? Start with [Getting started](/_docs/guides/getting-started.md), which walks through mapping a
first response end to end.

## Where to look

- **[Installation](/_docs/usage/installation.md)** and **[Setup](/_docs/usage/setup.md)** — add the
  package to your project and create a mapper instance.
- **[Architecture](/_docs/architecture.md)** — how the middleware chain fits together. Worth reading
  before writing your own.
- **Guides** — end-to-end walkthroughs, including
  [creating middleware](/_docs/guides/creating-middleware.md) and using JsonMapper with
  [Laravel](/_docs/guides/laravel-usage.md) or [Symfony](/_docs/guides/symfony-usage.md).
- **Middleware** — a page per middleware, from
  [typed properties](/_docs/middleware/typed-properties.md) and
  [DocBlock annotations](/_docs/middleware/doc-block-annotations.md) through to
  [renaming](/_docs/middleware/rename.md) and [value transformation](/_docs/middleware/value-transformation.md).
- **Advanced Usage** — [performance](/_docs/advanced-usage/performance.md),
  [casting values](/_docs/advanced-usage/casting-values.md), and mapping to
  [interfaces](/_docs/advanced-usage/interfaces.md) and
  [abstract classes](/_docs/advanced-usage/abstracts.md).

Every page has an "Edit Source" link if you spot something worth improving.
