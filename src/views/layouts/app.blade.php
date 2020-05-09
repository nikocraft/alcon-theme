<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">

<head>
    @include('includes/head')
</head>
<body>
    <div class="ikigai" id="app">
        @include('includes/header')
        @yield('content')
        @include('includes/footer')
    </div>

    <!-- Backend Routes -->
    @routes

    @php
        $themeFolder = get_theme_folder();
    @endphp

    <!-- Main script -->
    <script src="{{ mix('js/app.js', 'themes/' . $themeFolder) }}"></script>

    <!-- Third party js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>

    @if(get_theme_setting('syntaxHighlighter.enabled'))
        <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.20.0/components/prism-core.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.20.0/plugins/autoloader/prism-autoloader.min.js"></script>
        @if(get_theme_setting('syntaxHighlighter.lineNumbers'))
            <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.20.0/plugins/line-numbers/prism-line-numbers.min.js"></script>
        @endif
    @endif

    <!-- Theme's global js variables -->
    @include('includes/scripts')

    <!-- Theme custom javascript -->
    @if(get_theme_setting('custom.javascript'))
        <style id="theme-custom-javascript">
            {{ get_theme_setting('custom.javascript') }}
        </style>
    @endif

    <!-- Scripts injected by specific views -->
    @stack('scripts')
    <noscript>Please enable JavaScript to view this website correctly.</noscript>
</body>
</html>
