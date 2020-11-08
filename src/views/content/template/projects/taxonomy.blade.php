<div class="posts">
    @foreach ( $posts as $post )
        
    <div class="post">
        <h2 class="post-title"><a class="post-title-link" href="/{{ $post->type->slug }}/{{ $post->slug }}">{{ $post->title }}</a></h2>

        @if($post->featuredimage)
            <a class="post-image-link" href="/{{ $post->type->slug }}/{{ $post->slug }}">
                <div class="post-image" style='background-image: url({{ $post->featuredimage->original }});'></div>
            </a>
            {{-- <img src="{{ $post->featuredimage->original }}" class="img-responsive" alt=""> --}}
        @endif

        <div class="post-meta">
            <div class="post-meta-detail">
                Posted on {{ $post->created_at->format('Y-m-d') }} by {{ $post->author->username }}
            </div>
        </div>

        <div class="post-excerpt">
            {{ get_excerpt($post) }}
        </div>

        <div class="post-footer">
            <div class="post-meta-detail">
                <div class="post-taxonomy">
                    @taxonomy([
                        'taxonomy' => 'Tags',
                        'post' => $post,
                        'commaSeparate' => false
                    ]) @endtaxonomy
                </div>
            </div>
            {{-- <a class="btn btn-primary" href="/{{ $post->type->slug }}/{{ $post->slug }}">Read More</a> --}}
        </div>
    </div>
    @endforeach
</div>
{{ $posts->links() }}