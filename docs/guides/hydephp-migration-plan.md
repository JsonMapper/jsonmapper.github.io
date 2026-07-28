---
title: HydePHP 2 Migration Plan
---

This document outlines a full migration plan from the current Jekyll site to HydePHP 2 while preserving all existing content, URLs, and assets.

## Goals

- Replace Jekyll with HydePHP 2 as the static site generator.
- Keep all existing page URLs and information architecture stable.
- Preserve generated CSS/JS behavior and current design.
- Keep deployment to GitHub Pages simple and reproducible.

## Current State Inventory

1. **Content**
   - Homepage: `/index.md`
   - Documentation pages under `/docs/**`
2. **Templates**
   - Shared layout in `/_layouts/default.html`
3. **Navigation/Data**
   - Menu structure in `/_data/menu.yml`
   - Asset manifest in `/_data/manifest.yml`
4. **Assets**
   - Source assets in `/assets`
   - Generated assets in `/dist`
   - Static images/icons in `/images` and repository root
5. **Build**
   - Jekyll for page generation
   - Webpack/Tailwind pipeline from `package.json`

## Migration Phases

### Phase 1: Bootstrap HydePHP 2

1. Add HydePHP 2 project files (`composer.json`, Hyde config, and required directories).
2. Keep Node/Tailwind tooling initially to reduce change risk.
3. Add local development commands for Hyde serve/build workflows.

### Phase 2: Move Templates and Data

1. Port `/_layouts/default.html` into a Blade layout (for example `resources/views/layouts/app.blade.php`).
2. Convert Liquid syntax to Blade equivalents:
   - `{{ content }}` -> Blade content slot/yield
   - Menu loops -> Blade loops over data collections
   - Relative URL helpers -> Hyde/Laravel URL helpers
3. Move menu/manifest data into Hyde-supported data files or config-accessible structures.

### Phase 3: Move Markdown Content

1. Migrate root and `/docs/**` markdown pages into Hyde content directories.
2. Preserve front matter (`title`, `permalink`) and ensure route/path parity.
3. Validate all internal links after migration.

### Phase 4: Assets and Frontend Build

1. Keep current webpack build temporarily and point Hyde templates to generated files.
2. Confirm `dist` manifest usage still resolves CSS/JS correctly.
3. Optionally evaluate replacing webpack with a Hyde-native/Vite approach after parity is reached.

### Phase 5: CI/Deployment Cutover

1. Replace Jekyll build steps with:
   - `composer install --no-dev --prefer-dist`
   - `npm ci`
   - `npm run prod`
   - `php hyde build`
2. Publish Hyde output directory to GitHub Pages.
3. Remove Jekyll-specific configuration (`_config.yml`, Jekyll-only directories) only after successful cutover.

## Validation Checklist

- [ ] All existing routes resolve with the same public URLs.
- [ ] Navigation renders identically on desktop/mobile.
- [ ] Dark/light styles and code block styles match current behavior.
- [ ] Social/SEO meta tags are preserved.
- [ ] Generated site builds cleanly in CI and deploys to GitHub Pages.

## Risk Controls

- Migrate in small PRs by phase instead of a single large rewrite.
- Keep Jekyll branch/tag available until Hyde production validation completes.
- Run side-by-side local builds (Jekyll vs Hyde) to compare rendered output during migration.
