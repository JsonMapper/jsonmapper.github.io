{{--
    Overrides hyde::components.docs.sidebar-brand to show the JsonMapper logo
    instead of the plain text sidebar header.

    Only this one view is overridden; Laravel resolves hyde:: views from
    resources/views/vendor/hyde before falling back to the package, so the rest
    of the theme keeps tracking upstream.

    Two images rather than one because the wordmark needs to invert for dark
    mode, matching what the previous Jekyll layout did.

    The height cap is an inline style because app.css contains no max-h-*
    utilities, and the sidebar header leaves 2rem of content box.

    Both images are block-level on purpose. Left inline, an image sits on the
    text baseline and the line box adds descender space beneath it, which shifted
    the logo against the sidebar border in light mode only, since the dark variant
    was already block through dark:block.
--}}
<div id="sidebar-brand" class="flex items-center justify-between h-16 py-4 px-2">
    <strong class="px-2">
        @if(DocumentationPage::home())
            <a href="{{ DocumentationPage::home() }}" title="{{ $sidebar->getHeader() }}">
                <img src="{{ Hyde::asset('jsonmapper.png') }}" class="block dark:hidden" style="max-height:1.75rem;width:auto"
                     alt="{{ config('hyde.name', 'JsonMapper') }}" width="210" height="85">
                <img src="{{ Hyde::asset('jsonmapper-light.png') }}" class="hidden dark:block" style="max-height:1.75rem;width:auto"
                     alt="{{ config('hyde.name', 'JsonMapper') }}" width="210" height="85">
            </a>
        @else
            {{ $sidebar->getHeader() }}
        @endif
    </strong>
    <x-hyde::navigation.theme-toggle-button class="opacity-75 hover:opacity-100"/>
</div>
