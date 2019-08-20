<li data-id="{{ $comment->id }}">
    <div class="comment-main-level">
        <!-- Avatar -->
        <div class="comment-avatar"><img src="{{ $comment->user->avatar_full }}" alt=""></div>
        <!-- Contenedor del Comentario -->
        <div class="comment-box">
            <div class="comment-head">
                <h6 class="comment-name by-author"><a href="#">{{ $comment->user->name_full }}</a></h6>
                <span>{{ date('d/m-Y',$comment->created_at) }}</span>
                {{-- <i class="fa fa-reply"></i>
                <i class="fa fa-heart"></i> --}}
            </div>
            <div class="comment-content">
                {!! $comment->content !!}
            </div>
            <div class="box-reply">
                <div class="box-action">                       
                    <div class="btn-reply" title="Trả lời">Trả lời</div>
                    @if(Auth::check())
                        @if(Auth::user()->id == $comment->user_id || Auth::user()->level == App\User::USER_ADMIN)
                            <div class="btn-delete" title="Xóa bình luận" data-id="{{ $comment->id }}">Xóa</div>
                        @endif                        
                    @endif
                    
                </div>    
                <div class="box_add_comment">
                        <div class="box_input">
                            <input type="text" name="content" class="form-control" placeholder="Nhập nội dung bình luận">
                        </div>
                        <div class="box_submit">
                            <div class="delete_content" title="Hủy bỏ">
                                Hủy bỏ
                            </div>
                            <div class="send-comment" data-parent="{{ $comment->id }}">
                                <a href="#" title="Gửi bình luận">Bình luận</a>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Respuestas de los comentarios -->
    <ul class="comments-list reply-list">
        @if(isset($comment->comment_childs) && count($comment->comment_childs) > 0)
            @foreach ($comment->comment_childs as $comment_child)
                @include('course.detail.comment.comment_child')           
            @endforeach
        @endif                     
    </ul>
</li>