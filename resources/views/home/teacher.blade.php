@if(count($var['founders']) > 0)
    <div id="teacher">
        <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h3 class="teacher-title">Đội ngũ sáng lập</h3>
                <div class="border-bottom"></div>
                <div class="teacher-content">
                    <div class="slider-teacher" id="slider-teacher">
                    <div class="owl-carousel">
                        @foreach ($var['founders'] as $founder)
                                <div class="item">
                                    <div class="wrapper-teacher">
                                    <div class="box-image-teacher">
                                        <img src="{{ web_asset($founder->img) }}" />
                                    </div>
                                    <div class="box-description">
                                        <div class="value">{{ $founder->title }}</div>
                                        <h3 class="teacher-name">{{ $founder->name }}</h3>
                                        <div class="teacher-job"></div>
                                        <div class="teacher-des">{{ $founder->content }}</div>
                                    </div>
                                    </div>
                                </div>
                        @endforeach
                    </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
 @endif