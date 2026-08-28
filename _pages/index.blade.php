{{--
    The introduction lives at the documentation root, so the site root only
    forwards to it.

    This is a real page rather than a generated redirect so that the route
    exists during development: `hyde serve` resolves pages from the route
    index, and post-build redirects are not in it, which made "/" return a
    RouteNotFoundException locally even though the built site was correct.
--}}
@php($destination = Routes::get('docs/index')->getLink())
{{-- Relative for the refresh so it also works on a local dev server, absolute
     for the canonical so search engines get the real address. --}}
@php($canonical = Hyde::url('docs/index.html'))
<!doctype html>
<html lang="{{ config('hyde.language', 'en') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="refresh" content="0;url='{{ $destination }}'">
    <link rel="canonical" href="{{ $canonical }}">
    <title>{{ config('hyde.name', 'JsonMapper') }}</title>
</head>
<body>
    Redirecting to the <a href="{{ $destination }}">{{ config('hyde.name', 'JsonMapper') }} documentation</a>.
</body>
</html>
