{{--{{in_array(Route::current()->uri, ["cart","checkout/{token}", "checkout/{token}/success", "{slug?}"])?'nav_bar2':''}}--}}
{!! Theme::partial('pipes-header') !!}


<div class="ps-container">
    <div class="mt-40 mb-40">
        {!! Theme::content() !!}
    </div>
</div>

{!! Theme::partial('pipes-footer') !!}
