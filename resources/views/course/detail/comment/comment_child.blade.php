<li data-id={{ $comment_child->id }}>
    <!-- Avatar -->
    <div class="comment-avatar"><img src="{{ $comment_child->user->avatar_full }}" alt=""></div>
    <!-- Contenedor del Comentario -->
    <div class="comment-box">
        <div class="comment-head">
            <h6 class="comment-name by-author"><a href="#">{{ $comment_child->user->name_full }}</a></h6>
            <span>{{ date('d/m-Y',$comment_child->created_at) }}</span>
            {{-- <i class="fa fa-reply"></i>
            <i class="fa fa-heart"></i> --}}
        </div>
        <div class="comment-content">
                {!! $comment_child->content !!}
        </div>
    </div>
</li>