@if($var['support'] || Auth::user()->level == \App\User::USER_ADMIN || $var['course']->user_id == Auth::user()->id)
   <div style="text-align: center; background: #E8EDF2;padding: 10px;">
       <a class="box_edit_course" href="{{ route('course.detail',['id'=>$var['course']->id]) }}">
           <img src="{{ web_asset('public/images/course/icon/icon-edit_course.png') }}">
           Sửa khóa học
       </a>
   </div>
@endif

<div id="rating" class="box_rating">
    <div class="box_number">
        <div class="number">{{ $var['rating_avg'] }}</div>
        <p>{{ number_format($var['user_rating']) }} người đánh giá về khóa học</p>
    </div>
    <div class="rating">
        <div class="star-rating">
            <input type="hidden" name="rating_value" class="rating-value" value="">
            <span class="send_rating fa fa-star {{$var['my_rating'] >= 1 ? 'checked':''}}"  data-rating="1"></span>
            <span class="send_rating fa fa-star {{$var['my_rating'] >= 2 ? 'checked':''}}" data-rating="2"></span>
            <span class="send_rating fa fa-star {{$var['my_rating'] >= 3 ? 'checked':''}}" data-rating="3"></span>
            <span class="send_rating fa fa-star {{$var['my_rating'] >= 4 ? 'checked':''}}" data-rating="4"></span>
            <span class="send_rating fa fa-star {{$var['my_rating'] >= 5 ? 'checked':''}}" data-rating="5"></span>
        </div>
        @if($var['my_rating'] == 0)
            <p>Hãy đánh giá</p>
        @endif
    </div>
</div>     

<div class="box_teacher">
    <div class="info">
        <img src="{{ $var['course']->user->avatar_full }}" >
        <div class="username">
            <p>Người tạo</p>
            <p class="name">{{ $var['course']->user->name_full }}</p>
        </div>
    </div>
    <div class="des">
        {{ $var['course']->user->note }}
    </div>
</div>
<div class="box_course_same">
    @include('course.detail.course_same')
</div>
@push('js')
    <script>
       
       var rating = '{{ route('user.course.rating') }}';
       
    </script>
    <script src='{{ web_asset('public/js/detail/rating.js') }}' type='text/javascript'></script>
@endpush