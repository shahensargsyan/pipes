@php
    SeoHelper::setTitle(__('404 - Not found'));
    Theme::fire('beforeRenderTheme', app(\Botble\Theme\Contracts\Theme::class));
@endphp

{!! Theme::partial('pipes-header') !!}

<div class="ps-page--404">
    <div class="container">
        <div class="ps-section__content mt-40 mb-40" style="padding: 120px 0 100px 0;">
            <img src="{{ Theme::asset()->url('img/404.jpg') }}" alt="404">
            <h3>{{ __('Ohh! Page not found') }}</h3>
            <p>{{ __("It seems we can't find what you're looking for. Perhaps searching can help or go back to") }}<a href="{{ url('/') }}"> {{ __('Homepage') }}</a></p>

        </div>
    </div>
</div>

{!! Theme::partial('pipes-footer') !!}


