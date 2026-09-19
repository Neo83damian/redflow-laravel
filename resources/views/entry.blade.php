<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>REDFLOW - Blood Types Digital Masterlist</title>

    {{-- Open Graph / social preview — this is the image + text that shows
         up when this link is shared on Messenger, Facebook, etc. --}}
    <meta property="og:title" content="REDFLOW - Blood Types Digital Masterlist">
    <meta property="og:description" content="A community blood donation digital masterlist for Irosin Rural Health Unit.">
    <meta property="og:image" content="{{ asset('images/redflow-social-preview.png') }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url('/') }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="REDFLOW - Blood Types Digital Masterlist">
    <meta name="twitter:image" content="{{ asset('images/redflow-social-preview.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('images/redflow-social-preview.png') }}">

    <!-- FontAwesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Typography: Poppins (headings / brand) + Inter (body / UI) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@600;700;800&display=swap">

    <link rel="stylesheet" href="{{ asset('css/app-legacy.css') }}">

    {{-- OPTIONAL Tailwind/Vite assets — only included if you've actually run
         `npm install && npm run build`. If you haven't, this block is
         silently skipped and the page loads exactly as it did before,
         using only app-legacy.css above. This can never throw an error. --}}
    @if (file_exists(public_path('build/manifest.json')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body>

    @include('partials.auth-shell')
    @include('partials.app-shell')

    @if (auth()->check())
        <script>
            // Frontend expects these localStorage keys to already reflect an
            // active session on page load/refresh (so the app shell shows
            // immediately instead of the login view).
            window.__REDFLOW_SESSION_USER__ = @json(auth()->user()->toFrontendArray());
        </script>
    @endif

    <script src="{{ asset('js/script-legacy.js') }}"></script>
    <script>
        // Restores the session on a hard refresh, without touching any of
        // the original show/hide logic inside script-legacy.js itself.
        if (window.__REDFLOW_SESSION_USER__) {
            localStorage.setItem('redflow_logged_in', 'true');
            localStorage.setItem('redflow_current_user', JSON.stringify(window.__REDFLOW_SESSION_USER__));
        }
    </script>
</body>
</html>
