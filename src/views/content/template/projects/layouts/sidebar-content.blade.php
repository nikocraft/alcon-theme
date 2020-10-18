
<div class="container content-wrap">
    <div class="sidebar sidebar-left">
        @include('includes/sidebar')
    </div>

    <div class="content content-{{$pageType}} content-right">
        @include('content/template/projects/'.$pageType)
    </div>
</div>
