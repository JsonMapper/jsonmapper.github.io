@php($title = 'Map a JSON response to your PHP object')

{{--
    The JsonMapper landing page.

    A standalone Blade page rather than a Markdown one so the hero, code sample
    and feature cards can be laid out properly. It pulls in Hyde's head and
    scripts layouts, so it inherits the stylesheet, metadata, favicons, the
    no-flash dark mode script and the theme toggle from the rest of the site.

    Most of the styling uses utilities that are already in the precompiled
    _media/app.css. The scoped block below covers only what that file does not
    contain: the yellow accent from the old Jekyll header, responsive columns
    (no grid-cols-* utilities are compiled in) and a couple of radii. Keeping it
    here avoids reintroducing the Node build the migration removed.

    The code sample lives in resources/includes/home-example.md rather than being
    inlined here. A multi-line PHP block alongside the single-line front matter
    directive above makes Blade emit an unterminated opening tag and swallow the
    rest of the page, so the two must not be combined.
--}}


<!doctype html>
<html lang="{{ config('hyde.language', 'en') }}" class="scroll-smooth">
<head>
    @include('hyde::layouts.head')

    @verbatim
    <style>
        :root { --jm-accent: #eab308; --jm-card-border: #e5e7eb; --jm-card-bg: #ffffff; }
        .dark { --jm-card-border: #374151; --jm-card-bg: #111827; }

        .jm-accent-rule { border-bottom: 2px solid var(--jm-accent); }
        .jm-shell { max-width: 64rem; }

        /* Section rhythm lives here rather than in utility classes. app.css is
           precompiled and does not contain pb-16 or pt-16, so those silently do
           nothing; defining the spacing here cannot fail that way. */
        .jm-section { padding-top: 3.5rem; }
        .jm-section:last-child { padding-bottom: 3.5rem; }

        /* app.css has no max-h-* utilities, so the logo needs an explicit cap. */
        .jm-logo { max-height: 2.5rem; width: auto; }

        /* No grid-cols-* utilities are compiled into app.css, so columns live here. */
        .jm-cards { display: grid; gap: 1.5rem; grid-template-columns: 1fr; }
        @media (min-width: 768px) { .jm-cards { grid-template-columns: repeat(3, 1fr); } }

        .jm-card {
            border: 1px solid var(--jm-card-border);
            background: var(--jm-card-bg);
            border-radius: .75rem;
            padding: 1.5rem;
            border-top: 3px solid var(--jm-accent);
        }

        .jm-btn {
            display: inline-flex; align-items: center; gap: .5rem;
            padding: .625rem 1.25rem; border-radius: .5rem;
            font-weight: 600; text-decoration: none;
            transition: background-color .15s ease-in-out, border-color .15s ease-in-out;
        }
        .jm-btn-primary { background: var(--jm-accent); color: #1f2937; }
        .jm-btn-primary:hover { background: #ca8a04; }
        .jm-btn-secondary { border: 1px solid var(--jm-card-border); color: inherit; }
        .jm-btn-secondary:hover { border-color: var(--jm-accent); }

        .jm-install {
            display: inline-block; font-family: ui-monospace, Menlo, Consolas, monospace;
            border: 1px solid var(--jm-card-border); border-radius: .5rem;
            padding: .5rem .875rem; background: var(--jm-card-bg);
        }

        /* The container carries Hyde's prose classes, which is what gives the code
           block its background, padding and horizontal scrolling. Without them
           Torchlight's dark-theme colours land on the white page background and the
           lines overflow their container. */
        .jm-code { max-width: none; }
        .jm-code pre { margin: 0; }
    </style>
    @endverbatim
</head>
<body id="jsonmapper-home"
      class="flex flex-col min-h-screen overflow-x-hidden bg-white dark:bg-gray-900 dark:text-white"
      x-data="{}">

    @include('hyde::components.skip-to-content-button')

    <header class="jm-accent-rule">
        <div class="jm-shell mx-auto w-full flex items-center justify-between px-6 py-4">
            <a href="{{ Routes::get('index')->getLink() }}" title="{{ config('hyde.name') }}">
                <img src="{{ Hyde::asset('jsonmapper.png') }}" class="jm-logo dark:hidden"
                     alt="{{ config('hyde.name') }}" width="210" height="85">
                <img src="{{ Hyde::asset('jsonmapper-light.png') }}" class="jm-logo hidden dark:block"
                     alt="{{ config('hyde.name') }}" width="210" height="85">
            </a>

            <nav class="flex items-center gap-4">
                <a href="{{ Routes::get('docs/index')->getLink() }}" class="font-bold">Documentation</a>
                <a href="https://github.com/JsonMapper/JsonMapper" rel="noopener">GitHub</a>
                <x-hyde::navigation.theme-toggle-button class="opacity-75 hover:opacity-100"/>
            </nav>
        </div>
    </header>

    <main id="content" class="flex-grow">
        <section class="jm-shell jm-section mx-auto w-full px-6">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Map a JSON response to your PHP object</h1>

            <p class="text-lg mb-8 max-w-3xl">
                JsonMapper is a powerful open-source package that maps JSON data to PHP classes with ease. It offers a
                series of middleware that can be arranged and sorted to meet your specific needs, making it a flexible
                solution for a wide range of use cases.
            </p>

            <p class="mb-8"><span class="jm-install">composer require json-mapper/json-mapper</span></p>

            <p class="flex flex-wrap gap-4">
                <a class="jm-btn jm-btn-primary" href="{{ Routes::get('docs/getting-started')->getLink() }}">Get started</a>
                <a class="jm-btn jm-btn-secondary" href="{{ Routes::get('docs/index')->getLink() }}">Read the docs</a>
                <a class="jm-btn jm-btn-secondary" href="https://github.com/JsonMapper/JsonMapper" rel="noopener">View on GitHub</a>
            </p>
        </section>

        <section class="jm-shell jm-section mx-auto w-full px-6">
            <h2 class="text-2xl font-bold mb-4">A few lines is all it takes</h2>
            <p class="mb-4 max-w-3xl">
                With just a few lines of code you can map a JSON string to a PHP class and start working with it right away.
            </p>
            <div class="jm-code {{ config('markdown.prose_classes', 'prose dark:prose-invert') }}" data-copy-code>
                {!! Includes::markdown('home-example') !!}
            </div>
        </section>

        <section class="jm-shell jm-section mx-auto w-full px-6">
            <h2 class="text-2xl font-bold mb-8">Why use JsonMapper</h2>

            <div class="jm-cards">
                <article class="jm-card">
                    <h3 class="text-lg font-bold mb-4">Strong typing</h3>
                    <p>
                        Support for typed properties makes it easy to map JSON with strong type checking, on scalar values
                        as well as nested objects. On PHP 8.1 and up, enums work out of the box, and custom constructors
                        and readonly properties are supported too.
                    </p>
                </article>

                <article class="jm-card">
                    <h3 class="text-lg font-bold mb-4">Maps to your code</h3>
                    <p>
                        JsonMapper resolves namespace uses, so your implementation can stay organised the way you want it.
                        Map properties with PHP attributes or DocBlock annotations, transform values through a callback,
                        convert between naming conventions, and debug the mapping as it happens.
                    </p>
                </article>

                <article class="jm-card">
                    <h3 class="text-lg font-bold mb-4">Extensible by design</h3>
                    <p>
                        If the out-of-the-box middleware do not meet your needs, writing your own is straightforward.
                        Arrange the chain to fit your use case, and drop in custom middleware wherever you need it.
                    </p>
                </article>
            </div>
        </section>

        <section class="jm-shell jm-section mx-auto w-full px-6">
            <h2 class="text-2xl font-bold mb-4">Using a framework?</h2>
            <p class="mb-4 max-w-3xl">
                JsonMapper ships first-party integrations, so there is little to wire up yourself.
            </p>
            <p class="flex flex-wrap gap-4">
                <a class="jm-btn jm-btn-secondary" href="{{ Routes::get('docs/laravel-usage')->getLink() }}">Laravel</a>
                <a class="jm-btn jm-btn-secondary" href="{{ Routes::get('docs/symfony-usage')->getLink() }}">Symfony</a>
            </p>
        </section>
    </main>

    <footer class="mt-8">
        <div class="jm-shell mx-auto w-full px-6 py-8 flex flex-wrap gap-4 items-center justify-between">
            <p>{!! Hyde::markdown(config('hyde.footer'))->toHtml() !!}</p>
            <p class="flex flex-wrap gap-4">
                <a href="{{ Routes::get('docs/index')->getLink() }}">Documentation</a>
                <a href="https://github.com/JsonMapper/JsonMapper" rel="noopener">GitHub</a>
                <a href="https://twitter.com/JsonMapper" rel="noopener">Twitter</a>
            </p>
        </div>
    </footer>

    @include('hyde::layouts.scripts')
</body>
</html>
