@if(count($var['sliders']) >0 ) 
    <section class="slider-main mb15">
        <div id="slider-menu" class="slider-menu">
        <div class="owl-carousel">
            @foreach ($var['sliders'] as $slider)
            <div class="item">
                    <a href="{{ !empty($slider->url) ? $slider->url : '#' }}">
                        <picture>
                        {{-- <source media="(max-width: 767px)" srcset="../theme.hstatic.net/1000122408/1000253429/14/slide_index_1_large9bf4.jpg?v=31">
                        <source media="(min-width: 768px)" srcset="../theme.hstatic.net/1000122408/1000253429/14/slide_index_19bf4.jpg?v=31"> --}}
                        <img src="{{ web_asset($slider->img) }}" alt="{{ $slider->title }}" title="{{ $slider->title }}">
                        </picture>
                    </a>
                </div>
            @endforeach                        
        </div>
        </div>
    </section>
 @endif