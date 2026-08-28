{{--
    Overrides hyde::components.docs.sidebar-brand to show the JsonMapper logo
    instead of the plain text sidebar header.

    Only this one view is overridden; Laravel resolves hyde:: views from
    resources/views/vendor/hyde before falling back to the package, so the rest
    of the theme keeps tracking upstream.

    Two images rather than one because the wordmark needs to invert for dark
    mode, matching what the previous Jekyll layout did.
--}}
<div id="sidebar-brand" class="flex items-center justify-between h-16 py-4 px-2">
    <strong class="px-2">
        @if(DocumentationPage::home())
            <a href="{{ DocumentationPage::home() }}" title="{{ $sidebar->getHeader() }}">
                <img src="{{ Hyde::asset('jsonmapper.png') }}" class="max-h-10 w-auto dark:hidden"
                     alt="{{ config('hyde.name', 'JsonMapper') }}" width="210" height="85">
                <img src="{{ Hyde::asset('jsonmapper-light.png') }}" class="max-h-10 w-auto hidden dark:block"
                     alt="{{ config('hyde.name', 'JsonMapper') }}" width="210" height="85">
            </a>
        @else
            {{ $sidebar->getHeader() }}
        @endif
    </strong>
    <x-hyde::navigation.theme-toggle-button class="opacity-75 hover:opacity-100"/>
</div>
