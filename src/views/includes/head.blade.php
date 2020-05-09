
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<meta name="robots" content="index, follow" />
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- SEO Meta Tags -->
@stack('seo-meta-tags')

<!-- Open Graph / Facebook -->
@stack('open-graph-meta-tags')

<!-- Twitter -->
@stack('twitter-meta-tags')

<!-- Google Analytics Tracking Code Start -->
@if(get_theme_setting('seo.google.analyticsCode', null) != null)
{!! get_theme_setting('seo.google.analyticsCode') !!}
@endif
<!-- Google Analytics Tracking Code End -->

@php
    $fontResources = get_theme_setting('resources.fonts');
    $iconResources = get_theme_setting('resources.icons');
    $themeFolder = get_theme_folder();
@endphp

<!-- Theme Font Resource Start -->
@foreach ( $fontResources as $fontResource )
    @if($fontResource)
        <link rel="stylesheet" href="{{ $fontResource }}">
    @endif
@endforeach
<!-- Theme Font Resource End -->

<!-- Theme Icon Resource Start -->
@foreach ( $iconResources as $iconResource )
    @if($iconResource)
        <link rel="stylesheet" href="{{ $iconResource }}">
    @endif
@endforeach
<!-- Theme Icon Resource End -->

@if(get_theme_setting('syntaxHighlighter.enabled'))
    <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.20.0/themes/prism-{{get_theme_setting('syntaxHighlighter.theme')}}.min.css" rel="stylesheet" />
    @if(get_theme_setting('syntaxHighlighter.lineNumbers'))
        <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.20.0/plugins/line-numbers/prism-line-numbers.min.css" rel="stylesheet" />
    @endif
@endif

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css">

<!-- Theme Stylesheet -->
<link rel="stylesheet" href="{{mix('css/styles.css', 'themes/' . $themeFolder)}}">

{{-- Custom Styles for Image Zoom --}}
@include('includes/styles')

<!-- User Customized Theme Stylesheets -->
@if(file_exists('themes/' . $themeFolder . '/css/customize.css'))
    <link rel="stylesheet" href="{{ asset('themes/' . $themeFolder . '/css/customize.css') }}?{{ get_theme_timestamp() }}">
@endif

<!-- Theme Custom CSS -->
@if(get_theme_setting('custom.css'))
    <style id="theme-custom-css">
        {{ get_theme_setting('custom.css') }}
    </style>
@endif

<!-- Content Blocks Custom CSS Start -->
<style id="content-custom-css">
    @stack('content-custom-css')
</style>

<style id="large-devices-above-1200">
    @stack('content-block-css')
</style>

<style id="large-devices-less-than-1200">
    @media (max-width: 1199px) {
        @stack('content-block-css-large')
    }
</style>

<style id="medium-devices-less-than-992">
    @media (max-width: 991px) {
        @stack('content-block-css-medium')
    }
</style>

<style id="small-devices-less-than-768">
    @media (max-width: 767px) {
        @stack('content-block-css-small')
    }
</style>

<style id="small-devices-less-than-576">
    @media (max-width: 575px) {
        @stack('content-block-css-extra-small')
    }
</style>

<style id="custom-css">
    @stack('content-block-custom-css')
</style>

<!-- Content Blocks Custom CSS End -->


<script id="csrfToken">
    window.Laravel = {!! json_encode([
        'csrfToken' => csrf_token(),
    ]) !!};
</script>
