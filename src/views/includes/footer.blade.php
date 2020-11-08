
@php
$widgetGroup = get_widget_group('footer');
$widgetGroupVisible = false;
    list($widgets, $widgetsIds) = get_widgets($widgetGroup);
@endphp


<footer>
    <div class="container footer-wrap">
        @foreach($widgetsIds as $widgetId)
            @php
                $widgetGroupBlock = $widgets[$widgetId];
                $settings = $widgetGroupBlock->settings;
            @endphp
        
            @component('content.render.rootwidget', [
                'widgetId' => $widgetId,
                'widgets' => $widgets
            ])@endcomponent

        @endforeach
        <div class="footer-copyright">{{ get_theme_setting('footer.general.copyright') }} {{ now()->year }}</div>
    </div>
</footer>