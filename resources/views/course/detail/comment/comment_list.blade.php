<div class="comments-container">	
    <input type="hidden" name="course_id" value={{ $var['course']->id }} />
    @if(Auth::check())
        <div class="box_add_comment">
            <div class="box_input">
                    <img src="{{ Auth::user()->avatar_full }}" alt="">
                    <input type="text" name="content" class="form-control" placeholder="Nhập nội dung bình luận">
            </div>
            <div class="box_submit">
                <div class="delete_content" title="Hủy bỏ">
                    Hủy bỏ
                </div>
                <div class="send-comment" data-parent="0">
                    <a href="#" title="Gửi bình luận">Bình luận</a>
                </div>
            </div>
        </div>	
    @endif
    <ul id="comments-list" class="comments-list">
        @if(count($var['comments']) > 0)
            @foreach ($var['comments'] as $comment)
                @include('course.detail.comment.comment')
            @endforeach
        @endif        
    </ul>
    <div class="clearfix loadmore clear-ajax">
            <div class="paginations">
                    {{ $var['comments']->links('vendor.pagination.default') }}
            </div>
    </div>
</div>