<div id="rating" class="box-info">
    <div class="box-rate">
        <div class="number-rate">
            <div class="number">{{ $rating_avg }}</div>
            <div class="rating star-rating">
                    <input type="hidden" name="rating_value" class="rating-value" value="">
                    <span class="fa fa-star" data-rating="1"></span>
                    <span class="fa fa-star" data-rating="2"></span>
                    <span class="fa fa-star" data-rating="3"></span>
                    <span class="fa fa-star" data-rating="4"></span> 
                    <span class="fa fa-star" data-rating="5"></span>
                    <div class="fa send_rating" title="Gửi đánh giá">Gửi</div> 
            </div>
            <div class="count">
                    {{ number_format($user_rating) }} người đã đánh giá
            </div>
        </div>
        <div class="box-rate-action">
            <ul>
                @if(count($rating_value) > 0)
                    @foreach ($rating_value as $key => $rating_value)
                        <li>
                            <div class="value">{{ $key }}</div>
                            <div><span class="fa fa-star checked"></span></div>
                            <div class="border" style="width: {{ $user_rating > 0 ? ($rating_value['total']/$user_rating)*100 : 0 }}%"></div>
                            <div class="count">{{ $rating_value['users'] }}</div>
                        </li>  
                    @endforeach
                @endif                      
            </ul>
        </div>
    </div>
    @if(count($rating) > 0)
        <div class="list-user">
            <ul>         
                @foreach ($rating as $rating)
                    <li>
                        <div class="box-avatar">
                            <img src="{{ web_asset($rating->user->avatar_full) }}" >
                        </div>    
                        <div class="box-username"> 
                            <div class="username">{{ $rating->user->name_full }}</div>
                            <div class="rating">
                                    <span class="fa fa-star @if($rating->rating_value > 0) checked @endif"></span>
                                    <span class="fa fa-star @if($rating->rating_value > 1) checked @endif"></span>
                                    <span class="fa fa-star @if($rating->rating_value > 2) checked @endif"></span>
                                    <span class="fa fa-star @if($rating->rating_value > 3) checked @endif"></span>    
                                    <span class="fa fa-star @if($rating->rating_value > 4) checked @endif"></span>    
                            </div>
                        </div>
                    </li>    
                @endforeach                                      
            </ul>
        </div>
    @endif
</div>