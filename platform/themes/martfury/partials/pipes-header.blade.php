<!DOCTYPE html>
<html lang="en" xmlns="">
<head>
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-KKRGTXB');</script>
    <!-- End Google Tag Manager -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
{{--    <meta name="description" content="">--}}
{{--    <meta name="author" content="">--}}
{{--    <title>Wash Pipe </title>--}}
    <!-- Bootstrap core CSS -->
{{--    <link href="{!! Theme::asset()->url('pipes/lib/bootstrap/css/bootstrap.min.css') !!}" rel="stylesheet">--}}
    <link href="{!! Theme::asset()->url('http://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css') !!}" rel="stylesheet">
{{--    <link href="{!! Theme::asset()->url('pipes/lib/css/font-awesome.css') !!}" rel="stylesheet">--}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/3.2.1/css/font-awesome.min.css" integrity="sha512-IJ+BZHGlT4K43sqBGUzJ90pcxfkREDVZPZxeexRigVL8rzdw/gyJIflDahMdNzBww4k0WxpyaWpC2PLQUWmMUQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
{{--    <link href="{!! Theme::asset()->url('pipes/lib/css/font-awesome.css') !!}" rel="stylesheet">--}}
    <link href="{!! Theme::asset()->url('pipes/lib/css/slick.css') !!}" rel="stylesheet">
    <link href="{!! Theme::asset()->url('pipes/lib/css/slick-theme.css') !!}/" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"
          integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

    <!-- Main CSS -->
    <link href="{!! Theme::asset()->url('pipes/css/style.css') !!}" rel="stylesheet">

    <link href="{!! Theme::asset()->url('css/custom.css') !!}" rel="stylesheet">

    @if(Route::current()->uri == "/")
        <meta name="google-site-verification" content="r-iIt_h7Xj6R9h1nX2oMUU95ZcgZ8-mPL5rTW4CjEBU" />
    @endif
    @if (theme_option('favicon'))
        <link rel="shortcut icon" href="{{ RvMedia::getImageUrl(theme_option('favicon')) }}">
    @endif

    <!-- Facebook Pixel Code -->
    <script>
        <!-- Facebook Pixel Code -->
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};
            if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
            n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t,s)}(window, document,'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '1268049090256331');
        fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
                   src="https://www.facebook.com/tr?id=1268049090256331&ev=PageView&noscript=1"
        /></noscript>
    <!-- End Facebook Pixel Code -->

        <!-- This site is converting visitors into subscribers and customers with OptinMonster - https://optinmonster.com -->
        <script type="text/javascript" src="https://a.omappapi.com/app/js/api.min.js" data-account="2737" data-user="18405" async></script>
        <!-- / https://optinmonster.com -->

        @switch(Route::current()->uri)
            @case("/")
                {!! SeoHelper::render() !!}
            @break

            @case("cart")
                <title>Cart</title>
            @break

            @case("checkout/{token}")
            <title>Checkout</title>
            @break

            @case("checkout/{token}/success")
                <title>Thank You</title>
            @break

            @case("{slug?}")
            <title>Garden</title>
            @break

            @default
            Default case...
        @endswitch

        {{--{{in_array(Route::current()->uri, ["cart","checkout/{token}", "checkout/{token}/success", "{slug?}"])?'nav_bar2':''}}--}}


</head>

<body>
<div id="alert-container"></div>
@if(!in_array(Route::current()->uri, ["cart","checkout/{token}", "checkout/{token}/success", ]))

<nav class="nav_bar  nav_bar2">
    <div class="search_bar_form">
        <form>
            <input type="text" placeholder="Search.." name="search">
            <div class="close_btn"></div>
        </form>
    </div>
    <div class="container">
        <div class="logo"><a href="{{ url('/') }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="275" height="34" viewBox="0 0 275 34"><defs><style>.a{fill:#fff;}</style></defs><g transform="translate(-305.62 -68)"><path class="a" d="M14.714-16.8a5.731,5.731,0,0,0-1.442-.739,5.008,5.008,0,0,0-1.64-.264,4.794,4.794,0,0,0-2.01.416,4.81,4.81,0,0,0-1.567,1.128A5.229,5.229,0,0,0,7.03-14.594a5.6,5.6,0,0,0-.37,2.039,5.545,5.545,0,0,0,.37,2.032A5.167,5.167,0,0,0,8.055-8.868,4.774,4.774,0,0,0,9.622-7.753a4.86,4.86,0,0,0,2.01.409,6.416,6.416,0,0,0,.919-.066q.456-.066.972-.172v-2.942a.605.605,0,0,1,.145-.416.552.552,0,0,1,.436-.165h3.6a.746.746,0,0,1,.423.158.492.492,0,0,1,.225.422v5.872a.663.663,0,0,1-.384.581,7.271,7.271,0,0,1-1.376.726,11.322,11.322,0,0,1-1.574.5,14.1,14.1,0,0,1-1.66.3,13.959,13.959,0,0,1-1.633.1A10.062,10.062,0,0,1,9.033-2.8,10.016,10.016,0,0,1,6.62-3.821,10.167,10.167,0,0,1,4.576-5.4,10.233,10.233,0,0,1,3-7.429a9.846,9.846,0,0,1-1.018-2.4,9.993,9.993,0,0,1-.357-2.685A9.993,9.993,0,0,1,1.977-15.2,10.088,10.088,0,0,1,3-17.616a10.232,10.232,0,0,1,1.581-2.052A9.857,9.857,0,0,1,6.62-21.244,10.38,10.38,0,0,1,9.033-22.26a9.89,9.89,0,0,1,2.692-.363,9.95,9.95,0,0,1,3,.442,10.3,10.3,0,0,1,2.652,1.273.9.9,0,0,1,.344.35.47.47,0,0,1-.053.495l-2.143,3.088a.934.934,0,0,1-.344.284A.523.523,0,0,1,14.714-16.8Zm13.094-5.014a.391.391,0,0,1,.086-.172.949.949,0,0,1,.179-.172.944.944,0,0,1,.225-.125.623.623,0,0,1,.225-.046h3.386a.563.563,0,0,1,.384.139,1.7,1.7,0,0,1,.238.244L39.8-3.332a.388.388,0,0,1-.04.429.645.645,0,0,1-.5.165h-3.8A.832.832,0,0,1,35-2.851a.726.726,0,0,1-.258-.376q-.265-.673-.516-1.339t-.5-1.339H26.7q-.251.673-.509,1.339t-.509,1.339A.662.662,0,0,1,25-2.739H21.1a.647.647,0,0,1-.417-.132.312.312,0,0,1-.06-.4Zm2.407,5.647c-.168.449-1.869,5.581-2.037,6.03h4.06Zm12.248-5.555a.644.644,0,0,1,.145-.442.552.552,0,0,1,.436-.165h8.544a6.435,6.435,0,0,1,2.553.508,6.66,6.66,0,0,1,2.077,1.379,6.433,6.433,0,0,1,1.4,2.039,6.154,6.154,0,0,1,.509,2.487,5.887,5.887,0,0,1-.245,1.709,6.367,6.367,0,0,1-.681,1.517,6.447,6.447,0,0,1-1.038,1.28,6.79,6.79,0,0,1-1.316.983l3.4,6.386q.093.185.238.435a.9.9,0,0,1,.145.435.391.391,0,0,1-.139.323.583.583,0,0,1-.377.112H53.573a.662.662,0,0,1-.4-.132.6.6,0,0,1-.231-.356l-3.214-6.03H47.582v5.951q0,.567-.608.567H43.045a.621.621,0,0,1-.423-.139.54.54,0,0,1-.159-.429Zm10.065,5.858a2.281,2.281,0,0,0-.145-.792,2.57,2.57,0,0,0-.41-.726,2.4,2.4,0,0,0-.635-.554,2.175,2.175,0,0,0-.82-.29q-.37-.026-.694-.046t-.708-.02H47.582v4.842h2.143q.238,0,.423-.013t.41-.04a2.091,2.091,0,0,0,.833-.27,2.171,2.171,0,0,0,.622-.541,2.386,2.386,0,0,0,.384-.726A2.625,2.625,0,0,0,52.528-15.867Zm25.527,3.351A9.707,9.707,0,0,1,77.7-9.857,9.477,9.477,0,0,1,76.68-7.509,9.747,9.747,0,0,1,75.1-5.536a9.751,9.751,0,0,1-2.037,1.5,10.269,10.269,0,0,1-2.414.957,10.643,10.643,0,0,1-2.685.336H61.443a.839.839,0,0,1-.423-.106.474.474,0,0,1-.185-.449V-21.726a.651.651,0,0,1,.152-.449.578.578,0,0,1,.456-.172h6.521A10.374,10.374,0,0,1,70.642-22a10.154,10.154,0,0,1,2.407.976,10.3,10.3,0,0,1,2.043,1.517,9.378,9.378,0,0,1,1.581,1.979,9.912,9.912,0,0,1,1.018,2.362A9.563,9.563,0,0,1,78.055-12.516Zm-12.1-5.093V-7.462l.833.02q.3,0,.6-.02t.582-.046a5.33,5.33,0,0,0,1.852-.482,5.134,5.134,0,0,0,1.5-1.056,4.745,4.745,0,0,0,1.005-1.537,5.014,5.014,0,0,0,.364-1.926,4.93,4.93,0,0,0-.417-2.039,5.04,5.04,0,0,0-1.131-1.61,5.1,5.1,0,0,0-1.673-1.056,5.547,5.547,0,0,0-2.043-.376Zm15.554-4.117a.627.627,0,0,1,.152-.442.553.553,0,0,1,.429-.165H95.21a.583.583,0,0,1,.45.171.65.65,0,0,1,.159.46v3.263a.687.687,0,0,1-.159.428.551.551,0,0,1-.463.2H86.626v3.272h6.613a.7.7,0,0,1,.417.119.454.454,0,0,1,.165.4v2.85a.546.546,0,0,1-.145.356.524.524,0,0,1-.423.172H86.626v3.378h8.888a.531.531,0,0,1,.6.605v3.316A.326.326,0,0,1,96-3.107q-.053.368-.542.368H82.088a.618.618,0,0,1-.422-.139.54.54,0,0,1-.158-.429Zm17.908-.026a.612.612,0,0,1,.145-.409.54.54,0,0,1,.436-.172h4.325a.907.907,0,0,1,.384.092.837.837,0,0,1,.344.317q1.68,2.7,3.333,5.331t3.346,5.331V-21.831a.645.645,0,0,1,.212-.369.562.562,0,0,1,.37-.132h3.77a.706.706,0,0,1,.463.152.523.523,0,0,1,.185.429v18.5a.466.466,0,0,1-.159.389.687.687,0,0,1-.436.125h-4.219a.442.442,0,0,1-.3-.119,2.091,2.091,0,0,1-.278-.317l-3.479-5.74q-1.719-2.837-3.492-5.74V-3.319a.628.628,0,0,1-.132.435.628.628,0,0,1-.476.145H100a.548.548,0,0,1-.443-.165.6.6,0,0,1-.139-.4Zm29.971,0a.666.666,0,0,1,.165-.4.5.5,0,0,1,.4-.178h3.928a.673.673,0,0,1,.41.165.508.508,0,0,1,.212.416v6.266h6.574v-6.266a.571.571,0,0,1,.165-.41.568.568,0,0,1,.429-.172h3.865A.813.813,0,0,1,146-22.2a.47.47,0,0,1,.2.422V-3.319a.538.538,0,0,1-.172.435.671.671,0,0,1-.448.145h-3.9a.625.625,0,0,1-.429-.145.55.55,0,0,1-.165-.435v-7.495h-6.574v7.495a.532.532,0,0,1-.179.429.721.721,0,0,1-.483.152h-3.889q-.556,0-.569-.515Zm25.342,9.223a5.588,5.588,0,0,0,.37,2.045,5.05,5.05,0,0,0,1.037,1.656,4.833,4.833,0,0,0,1.578,1.108,4.916,4.916,0,0,0,2.008.4,4.962,4.962,0,0,0,2.014-.4,4.815,4.815,0,0,0,1.585-1.108,5.05,5.05,0,0,0,1.037-1.656,5.589,5.589,0,0,0,.37-2.045,5.6,5.6,0,0,0-.37-2.039,5.11,5.11,0,0,0-1.037-1.669,4.85,4.85,0,0,0-1.585-1.122,4.893,4.893,0,0,0-2.014-.409,4.848,4.848,0,0,0-2.008.409,4.87,4.87,0,0,0-1.578,1.122,5.109,5.109,0,0,0-1.037,1.669A5.6,5.6,0,0,0,154.728-12.529Zm-5.119.013a9.987,9.987,0,0,1,.357-2.685,10.084,10.084,0,0,1,1.019-2.415,10.232,10.232,0,0,1,1.582-2.052,9.864,9.864,0,0,1,2.045-1.577,10.39,10.39,0,0,1,2.415-1.016,9.9,9.9,0,0,1,2.693-.363,9.926,9.926,0,0,1,2.687.363,10.36,10.36,0,0,1,2.422,1.016,10.021,10.021,0,0,1,2.051,1.577,9.919,9.919,0,0,1,1.582,2.052,10.453,10.453,0,0,1,1.019,2.415,9.817,9.817,0,0,1,.364,2.685,9.817,9.817,0,0,1-.364,2.685,10.2,10.2,0,0,1-1.019,2.4A9.918,9.918,0,0,1,166.882-5.4a10.341,10.341,0,0,1-2.051,1.577A10,10,0,0,1,162.408-2.8a10.1,10.1,0,0,1-2.687.356,10.076,10.076,0,0,1-2.693-.356,10.025,10.025,0,0,1-2.415-1.016A10.175,10.175,0,0,1,152.568-5.4a10.234,10.234,0,0,1-1.582-2.032,9.842,9.842,0,0,1-1.019-2.4A9.987,9.987,0,0,1,149.61-12.516Zm25.117,3.444q.225.185.575.495a7.748,7.748,0,0,0,.8.614,6.731,6.731,0,0,0,1.336.7,3.885,3.885,0,0,0,1.389.251,3.626,3.626,0,0,0,1.131-.152,1.908,1.908,0,0,0,.721-.4,1.423,1.423,0,0,0,.377-.58,2.15,2.15,0,0,0,.112-.7,1.028,1.028,0,0,0-.311-.732,3.22,3.22,0,0,0-.761-.573,6.476,6.476,0,0,0-.939-.429q-.489-.178-.846-.3a19.388,19.388,0,0,1-2.778-1.193,8.565,8.565,0,0,1-1.984-1.424,5.331,5.331,0,0,1-1.19-1.727,5.37,5.37,0,0,1-.4-2.1,4.953,4.953,0,0,1,.5-2.228,4.9,4.9,0,0,1,1.415-1.714,6.743,6.743,0,0,1,2.215-1.1,10.061,10.061,0,0,1,2.9-.389,9.669,9.669,0,0,1,2.308.27,8.8,8.8,0,0,1,2.176.864q.45.264.853.548a8.864,8.864,0,0,1,.708.548,3.344,3.344,0,0,1,.483.5.728.728,0,0,1,.179.409.61.61,0,0,1-.086.317,2.007,2.007,0,0,1-.258.33l-2.024,2.151a.648.648,0,0,1-.45.224.578.578,0,0,1-.337-.106q-.152-.106-.337-.264l-.119-.106q-.265-.224-.589-.462a5.242,5.242,0,0,0-.694-.429,4.672,4.672,0,0,0-.78-.317,2.835,2.835,0,0,0-.833-.125,4.41,4.41,0,0,0-.82.073,2.3,2.3,0,0,0-.675.231,1.282,1.282,0,0,0-.463.416,1.1,1.1,0,0,0-.172.627,1.105,1.105,0,0,0,.185.64,1.834,1.834,0,0,0,.556.5,5.143,5.143,0,0,0,.919.435q.549.2,1.276.442,1.4.462,2.586.97a8.711,8.711,0,0,1,2.043,1.2,4.963,4.963,0,0,1,1.342,1.656,5.168,5.168,0,0,1,.483,2.335,5.765,5.765,0,0,1-.6,2.632,6.021,6.021,0,0,1-1.633,2.012,7.633,7.633,0,0,1-2.44,1.286,9.71,9.71,0,0,1-3.016.455,8.562,8.562,0,0,1-2.989-.543,11.489,11.489,0,0,1-2.738-1.456,7.067,7.067,0,0,1-.893-.754q-.364-.37-.575-.6l-.04-.04a.071.071,0,0,0-.026-.033.1.1,0,0,1-.026-.02.071.071,0,0,0-.026-.033.1.1,0,0,1-.026-.02.925.925,0,0,1-.3-.529.75.75,0,0,1,.3-.5l2.288-2.177a.862.862,0,0,1,.45-.2.492.492,0,0,1,.251.079A2.452,2.452,0,0,1,174.727-9.072Zm14.88-12.654a.627.627,0,0,1,.152-.442.553.553,0,0,1,.429-.165h13.122a.583.583,0,0,1,.45.171.65.65,0,0,1,.159.46v3.263a.687.687,0,0,1-.159.428.551.551,0,0,1-.463.2h-8.571v3.272h6.151a.7.7,0,0,1,.417.119.454.454,0,0,1,.165.4v2.85a.546.546,0,0,1-.145.356.524.524,0,0,1-.423.172h-6.164v3.378h8.888a.531.531,0,0,1,.6.605v3.316a.326.326,0,0,1-.106.237q-.053.368-.542.368H190.187a.618.618,0,0,1-.422-.139.54.54,0,0,1-.158-.429Zm25.9,0a.644.644,0,0,1,.145-.442.552.552,0,0,1,.436-.165h8.452a5.764,5.764,0,0,1,1.719.251,5.859,5.859,0,0,1,1.481.693,6.028,6.028,0,0,1,1.217,1.056,6.8,6.8,0,0,1,.919,1.326,6.7,6.7,0,0,1,.575,1.5,6.465,6.465,0,0,1,.2,1.59,6.505,6.505,0,0,1-.43,2.322,6.372,6.372,0,0,1-1.223,2.019,6.232,6.232,0,0,1-1.9,1.432,5.616,5.616,0,0,1-2.46.561h-4.008v6.281q0,.567-.608.567h-3.928a.621.621,0,0,1-.423-.139.54.54,0,0,1-.159-.429Zm9.742,5.779a2.378,2.378,0,0,0-.139-.792,2.2,2.2,0,0,0-.4-.706,2.142,2.142,0,0,0-.641-.508,1.807,1.807,0,0,0-.853-.2h-2.586v4.407h2.586a1.9,1.9,0,0,0,.86-.191,2,2,0,0,0,.641-.495,2.186,2.186,0,0,0,.4-.7A2.453,2.453,0,0,0,225.245-15.947Zm8.3-5.779a.644.644,0,0,1,.145-.442.552.552,0,0,1,.436-.165h8.544a6.435,6.435,0,0,1,2.553.508,6.66,6.66,0,0,1,2.077,1.379,6.434,6.434,0,0,1,1.4,2.039,6.155,6.155,0,0,1,.509,2.487,5.887,5.887,0,0,1-.245,1.709,6.366,6.366,0,0,1-.681,1.517,6.446,6.446,0,0,1-1.038,1.28,6.789,6.789,0,0,1-1.316.983l3.4,6.386q.093.185.238.435a.9.9,0,0,1,.145.435.391.391,0,0,1-.139.323.583.583,0,0,1-.377.112h-4.537a.662.662,0,0,1-.4-.132.6.6,0,0,1-.231-.356l-3.214-6.03h-2.143v5.951q0,.567-.608.567h-3.928a.621.621,0,0,1-.423-.139.54.54,0,0,1-.159-.429Zm10.178,5.858a2.281,2.281,0,0,0-.145-.792,2.57,2.57,0,0,0-.41-.726,2.4,2.4,0,0,0-.635-.554,2.175,2.175,0,0,0-.82-.29q-.37-.026-.694-.046t-.708-.02h-1.647v4.842h2.255q.238,0,.423-.013t.41-.04a2.091,2.091,0,0,0,.833-.27,2.172,2.172,0,0,0,.622-.541,2.386,2.386,0,0,0,.384-.726A2.624,2.624,0,0,0,243.722-15.867Z" transform="translate(304 103.859)"/><g transform="translate(556.368 68)"><path class="a" d="M1133.922,2052.823a4.266,4.266,0,1,0,4.266,4.266A4.271,4.271,0,0,0,1133.922,2052.823Z" transform="translate(-1121.878 -2034.602)"/><path class="a" d="M1119.428,1984.6c-.707-1.209-2.8-2.791-3.106-3.551s.007-1.26-.177-1.613-.226-.8-.751-1.03a41.767,41.767,0,0,0-4.421-.358,1.359,1.359,0,0,1-.8-.4c-.167-.254-.847-.748-3.12-.349a.456.456,0,0,0-.371.5l.394,3.628a.451.451,0,0,0,.477.405,11.072,11.072,0,0,0,2.134-.288c.619-.224.928-.9,1.282-.945s.486.049.752.721c.24.607,1.311,3.3,1.514,3.813a9.129,9.129,0,0,0-5.573-1.637v0h-.392v0a8.335,8.335,0,0,0-7.046,3.132,25.04,25.04,0,0,0-3.217,6.853,12.288,12.288,0,0,0-.263,11.3h0a12.078,12.078,0,0,0,.845,1.456c.461.881.885,1.427.6,1.76a1.585,1.585,0,0,0-.4,1.792c.265.627-.088,1.209,2.52,1.254,1.738.03,2.73.08,3.2.11a.32.32,0,0,0,.338-.323v-.35a11.887,11.887,0,0,0,7.183.014v.331a.32.32,0,0,0,.338.322c.469-.03,1.461-.08,3.2-.11,2.608-.044,2.254-.627,2.52-1.254a1.586,1.586,0,0,0-.4-1.792c-.254-.3.068-.689.472-1.5a12.289,12.289,0,0,0,1.66-10.935,10.325,10.325,0,0,0,.189-5.319c-.751-2.329-4.621-7.863-4.356-8.132s.265-.448.575-.269a16.119,16.119,0,0,1,3.34,4.157c.31.493.4.806.663.672S1120.135,1985.8,1119.428,1984.6Zm-15.155,1.4a15.931,15.931,0,0,1,2.871-.365v.007s.028,0,.084,0a.446.446,0,0,1,.046,0v-.005a17.375,17.375,0,0,1,3.472.364,2.743,2.743,0,0,1,2.355,2.677h0a11.85,11.85,0,0,0-11.184-.044A2.736,2.736,0,0,1,1104.272,1985.993Zm11.765,13.381a8.681,8.681,0,0,1-2.51,6.138,8.488,8.488,0,0,1-12.117,0,8.762,8.762,0,0,1,0-12.277,8.489,8.489,0,0,1,12.117,0A8.681,8.681,0,0,1,1116.037,1999.374Z" transform="translate(-1095.5 -1977.141)"/></g></g></svg>
            </a>
        </div>
        <div class="logo_mob">
            <a href="href="{{ url('/') }}"">
            <svg xmlns="http://www.w3.org/2000/svg" width="116.233" height="43.768" viewBox="0 0 116.233 43.768"><defs><style>.a{fill:#42cb1b;}</style></defs><g transform="translate(-15.418 -14.213)"><g transform="translate(15.418 31.14)"><path class="a" d="M129.387-21.963a.526.526,0,0,1,.131-.318.4.4,0,0,1,.318-.141h3.1a.531.531,0,0,1,.324.13.4.4,0,0,1,.167.329v4.947h5.189v-4.947a.451.451,0,0,1,.13-.323.448.448,0,0,1,.339-.136h3.051a.642.642,0,0,1,.365.1.371.371,0,0,1,.156.333V-7.411a.425.425,0,0,1-.135.344.529.529,0,0,1-.354.115h-3.083a.494.494,0,0,1-.339-.115.434.434,0,0,1-.13-.344v-5.917h-5.189v5.917a.42.42,0,0,1-.141.339.569.569,0,0,1-.381.12h-3.07q-.439,0-.449-.406Zm20.006,7.281a4.412,4.412,0,0,0,.292,1.615,3.987,3.987,0,0,0,.819,1.307,3.816,3.816,0,0,0,1.246.875,3.881,3.881,0,0,0,1.585.318,3.918,3.918,0,0,0,1.59-.318,3.8,3.8,0,0,0,1.251-.875,3.987,3.987,0,0,0,.819-1.307,4.412,4.412,0,0,0,.292-1.615,4.424,4.424,0,0,0-.292-1.609,4.034,4.034,0,0,0-.819-1.318,3.829,3.829,0,0,0-1.251-.885,3.863,3.863,0,0,0-1.59-.323,3.827,3.827,0,0,0-1.585.323,3.844,3.844,0,0,0-1.246.885,4.034,4.034,0,0,0-.819,1.318A4.424,4.424,0,0,0,149.393-14.682Zm-4.041.01a7.884,7.884,0,0,1,.282-2.12,7.961,7.961,0,0,1,.8-1.906,8.078,8.078,0,0,1,1.249-1.62,7.787,7.787,0,0,1,1.614-1.245,8.2,8.2,0,0,1,1.907-.8,7.818,7.818,0,0,1,2.126-.286,7.836,7.836,0,0,1,2.121.286,8.179,8.179,0,0,1,1.912.8,7.912,7.912,0,0,1,1.619,1.245,7.83,7.83,0,0,1,1.249,1.62,8.253,8.253,0,0,1,.8,1.906,7.75,7.75,0,0,1,.287,2.12,7.75,7.75,0,0,1-.287,2.12,8.05,8.05,0,0,1-.8,1.9,7.829,7.829,0,0,1-1.249,1.6,8.165,8.165,0,0,1-1.619,1.245,7.894,7.894,0,0,1-1.912.8,7.972,7.972,0,0,1-2.121.281,7.954,7.954,0,0,1-2.126-.281,7.914,7.914,0,0,1-1.907-.8,8.032,8.032,0,0,1-1.614-1.245,8.079,8.079,0,0,1-1.249-1.6,7.77,7.77,0,0,1-.8-1.9A7.884,7.884,0,0,1,145.352-14.672Zm19.828,2.719q.178.146.454.391a6.114,6.114,0,0,0,.632.484,5.314,5.314,0,0,0,1.055.552,3.067,3.067,0,0,0,1.1.2,2.863,2.863,0,0,0,.893-.12,1.506,1.506,0,0,0,.569-.317,1.124,1.124,0,0,0,.3-.458,1.7,1.7,0,0,0,.089-.552.811.811,0,0,0-.245-.578,2.542,2.542,0,0,0-.6-.453,5.114,5.114,0,0,0-.741-.338q-.386-.141-.668-.234a15.306,15.306,0,0,1-2.193-.942,6.762,6.762,0,0,1-1.566-1.124,4.208,4.208,0,0,1-.94-1.363,4.239,4.239,0,0,1-.313-1.66,3.91,3.91,0,0,1,.392-1.759,3.866,3.866,0,0,1,1.117-1.353,5.323,5.323,0,0,1,1.749-.869,7.943,7.943,0,0,1,2.287-.307,7.633,7.633,0,0,1,1.822.214,6.948,6.948,0,0,1,1.718.682q.355.208.673.432a6.993,6.993,0,0,1,.559.432,2.639,2.639,0,0,1,.381.4.575.575,0,0,1,.141.323.482.482,0,0,1-.068.25,1.586,1.586,0,0,1-.2.26l-1.6,1.7a.512.512,0,0,1-.355.177.457.457,0,0,1-.266-.083q-.12-.083-.266-.208l-.094-.083q-.209-.177-.465-.365a4.139,4.139,0,0,0-.548-.339,3.688,3.688,0,0,0-.616-.25,2.238,2.238,0,0,0-.658-.1,3.482,3.482,0,0,0-.647.057,1.814,1.814,0,0,0-.533.182,1.012,1.012,0,0,0-.365.328.87.87,0,0,0-.136.495.873.873,0,0,0,.146.505,1.448,1.448,0,0,0,.439.4,4.059,4.059,0,0,0,.726.344q.433.161,1.008.349,1.107.365,2.041.766a6.877,6.877,0,0,1,1.613.948,3.918,3.918,0,0,1,1.06,1.307,4.08,4.08,0,0,1,.381,1.844,4.551,4.551,0,0,1-.47,2.078,4.754,4.754,0,0,1-1.29,1.589,6.026,6.026,0,0,1-1.926,1.016,7.665,7.665,0,0,1-2.381.359,6.759,6.759,0,0,1-2.36-.428,9.07,9.07,0,0,1-2.161-1.149,5.58,5.58,0,0,1-.7-.6q-.287-.292-.454-.47l-.031-.031a.056.056,0,0,0-.021-.026.08.08,0,0,1-.021-.016.056.056,0,0,0-.021-.026.081.081,0,0,1-.021-.016.73.73,0,0,1-.24-.418.592.592,0,0,1,.24-.4l1.806-1.719a.68.68,0,0,1,.355-.156.388.388,0,0,1,.2.063A1.935,1.935,0,0,1,165.18-11.953Zm11.747-9.989a.5.5,0,0,1,.12-.349.437.437,0,0,1,.339-.13h10.359a.46.46,0,0,1,.355.135.513.513,0,0,1,.125.364v2.576a.542.542,0,0,1-.125.338.435.435,0,0,1-.365.161h-6.766v2.583h4.856a.55.55,0,0,1,.329.094.358.358,0,0,1,.131.312v2.25a.431.431,0,0,1-.115.281.414.414,0,0,1-.334.135h-4.866v2.667h7.017a.419.419,0,0,1,.47.478v2.617a.257.257,0,0,1-.084.187q-.042.291-.428.291H177.385a.488.488,0,0,1-.333-.109.427.427,0,0,1-.125-.339Zm20.445,0a.509.509,0,0,1,.115-.349.435.435,0,0,1,.345-.13H204.5a4.55,4.55,0,0,1,1.357.2,4.625,4.625,0,0,1,1.169.547,4.758,4.758,0,0,1,.961.833,5.363,5.363,0,0,1,.726,1.047,5.29,5.29,0,0,1,.454,1.182,5.1,5.1,0,0,1,.157,1.255,5.136,5.136,0,0,1-.339,1.833,5.031,5.031,0,0,1-.966,1.594,4.919,4.919,0,0,1-1.5,1.13,4.433,4.433,0,0,1-1.942.443h-3.164V-7.4q0,.448-.48.448h-3.1a.49.49,0,0,1-.334-.109.426.426,0,0,1-.125-.339Zm7.69,4.562a1.877,1.877,0,0,0-.11-.625,1.735,1.735,0,0,0-.318-.557,1.691,1.691,0,0,0-.506-.4,1.427,1.427,0,0,0-.673-.156h-2.042v3.479h2.042a1.5,1.5,0,0,0,.679-.151,1.581,1.581,0,0,0,.506-.391,1.726,1.726,0,0,0,.313-.552A1.937,1.937,0,0,0,205.062-17.38Zm6.552-4.562a.508.508,0,0,1,.115-.349.435.435,0,0,1,.345-.13h6.745a5.08,5.08,0,0,1,2.015.4,5.258,5.258,0,0,1,1.639,1.089,5.079,5.079,0,0,1,1.1,1.609,4.859,4.859,0,0,1,.4,1.964,4.648,4.648,0,0,1-.193,1.349,5.027,5.027,0,0,1-.538,1.2,5.089,5.089,0,0,1-.82,1.01,5.36,5.36,0,0,1-1.039.776l2.683,5.042q.073.146.188.344a.712.712,0,0,1,.115.344.309.309,0,0,1-.11.255.46.46,0,0,1-.3.089h-3.581a.523.523,0,0,1-.318-.1.473.473,0,0,1-.183-.281l-2.537-4.76h-1.692v4.7q0,.448-.48.448h-3.1a.49.49,0,0,1-.334-.109.426.426,0,0,1-.125-.339Zm8.035,4.625a1.8,1.8,0,0,0-.115-.625,2.028,2.028,0,0,0-.324-.573,1.9,1.9,0,0,0-.5-.437,1.717,1.717,0,0,0-.647-.229l-.548-.036q-.256-.016-.559-.016h-1.3v3.823h1.781q.188,0,.334-.01t.324-.031a1.651,1.651,0,0,0,.658-.214,1.714,1.714,0,0,0,.491-.427,1.884,1.884,0,0,0,.3-.573A2.072,2.072,0,0,0,219.649-17.318Z" transform="translate(-129.387 33.1)"/><g transform="translate(97.088 0)"><path class="a" d="M1133.024,2052.823a3.368,3.368,0,1,0,3.368,3.368A3.372,3.372,0,0,0,1133.024,2052.823Z" transform="translate(-1123.516 -2038.438)"/><path class="a" d="M1114.39,1983.026c-.558-.955-2.208-2.2-2.452-2.8s.005-.995-.14-1.273-.178-.632-.593-.813a32.983,32.983,0,0,0-3.49-.283,1.07,1.07,0,0,1-.628-.318c-.132-.2-.669-.59-2.463-.275a.36.36,0,0,0-.293.395l.311,2.864a.357.357,0,0,0,.377.32,8.72,8.72,0,0,0,1.685-.228c.489-.177.733-.71,1.012-.746s.384.039.594.569c.189.479,1.035,2.607,1.2,3.01a7.207,7.207,0,0,0-4.4-1.292v0h-.309v0a6.579,6.579,0,0,0-5.562,2.473,19.762,19.762,0,0,0-2.54,5.41,9.7,9.7,0,0,0-.208,8.917h0a9.52,9.52,0,0,0,.667,1.149c.364.7.7,1.127.477,1.389a1.251,1.251,0,0,0-.314,1.415c.209.495-.07.955,1.989.99,1.372.023,2.155.063,2.525.087a.253.253,0,0,0,.267-.255v-.276a9.383,9.383,0,0,0,5.671.011v.261a.253.253,0,0,0,.267.254c.37-.023,1.153-.063,2.525-.086,2.059-.035,1.78-.5,1.989-.99a1.252,1.252,0,0,0-.314-1.415c-.2-.237.053-.544.373-1.186a9.7,9.7,0,0,0,1.31-8.632,8.152,8.152,0,0,0,.149-4.2c-.593-1.839-3.648-6.208-3.439-6.42s.209-.354.454-.212a12.726,12.726,0,0,1,2.637,3.282c.244.389.314.636.523.53S1114.948,1983.981,1114.39,1983.026Zm-11.964,1.1a12.559,12.559,0,0,1,2.267-.288v.005l.067,0,.036,0v0a13.7,13.7,0,0,1,2.741.287,2.165,2.165,0,0,1,1.859,2.114h0a9.355,9.355,0,0,0-8.829-.035A2.159,2.159,0,0,1,1102.425,1984.129Zm9.288,10.563a6.854,6.854,0,0,1-1.981,4.846,6.7,6.7,0,0,1-9.566,0,6.916,6.916,0,0,1,0-9.692,6.7,6.7,0,0,1,9.566,0A6.854,6.854,0,0,1,1111.713,1994.693Z" transform="translate(-1095.5 -1977.141)"/></g></g><path class="a" d="M11.878-18.029a4.477,4.477,0,0,0-1.129-.583,3.9,3.9,0,0,0-1.285-.208,3.73,3.73,0,0,0-1.575.328,3.769,3.769,0,0,0-1.228.891,4.133,4.133,0,0,0-.8,1.318,4.449,4.449,0,0,0-.29,1.609,4.407,4.407,0,0,0,.29,1.6,4.084,4.084,0,0,0,.8,1.307,3.741,3.741,0,0,0,1.228.88,3.782,3.782,0,0,0,1.575.323,4.988,4.988,0,0,0,.72-.052q.357-.052.762-.135v-2.323a.48.48,0,0,1,.114-.328.43.43,0,0,1,.342-.13h2.818a.582.582,0,0,1,.332.125.389.389,0,0,1,.176.333v4.635a.523.523,0,0,1-.3.458,5.681,5.681,0,0,1-1.078.573,8.82,8.82,0,0,1-1.233.4,10.97,10.97,0,0,1-1.3.234,10.852,10.852,0,0,1-1.28.078,7.825,7.825,0,0,1-2.108-.281,7.814,7.814,0,0,1-1.891-.8,7.973,7.973,0,0,1-1.6-1.245,8.071,8.071,0,0,1-1.238-1.6,7.805,7.805,0,0,1-.8-1.9,7.946,7.946,0,0,1-.28-2.12,7.946,7.946,0,0,1,.28-2.12,8,8,0,0,1,.8-1.906,8.07,8.07,0,0,1,1.238-1.62,7.729,7.729,0,0,1,1.6-1.245,8.1,8.1,0,0,1,1.891-.8,7.692,7.692,0,0,1,2.108-.286,7.739,7.739,0,0,1,2.347.349,8.038,8.038,0,0,1,2.077,1.005.711.711,0,0,1,.269.276.373.373,0,0,1-.041.391L12.51-18.165a.733.733,0,0,1-.269.224A.407.407,0,0,1,11.878-18.029Zm10.258-3.958a.31.31,0,0,1,.067-.135.746.746,0,0,1,.14-.135.738.738,0,0,1,.176-.1.485.485,0,0,1,.176-.036h2.652a.439.439,0,0,1,.3.109,1.339,1.339,0,0,1,.186.193l5.7,14.7a.308.308,0,0,1-.031.339.5.5,0,0,1-.394.13H28.134a.648.648,0,0,1-.368-.089.573.573,0,0,1-.2-.3q-.207-.531-.4-1.057t-.394-1.057h-5.5q-.2.531-.4,1.057t-.4,1.057a.519.519,0,0,1-.528.385H16.882a.5.5,0,0,1-.326-.1.247.247,0,0,1-.047-.312Zm1.886,4.458c-.131.354-1.464,4.406-1.6,4.76h3.181Zm9.594-4.385a.511.511,0,0,1,.114-.349.43.43,0,0,1,.342-.13h6.693a5.007,5.007,0,0,1,2,.4A5.215,5.215,0,0,1,44.391-20.9a5.081,5.081,0,0,1,1.093,1.609,4.891,4.891,0,0,1,.4,1.964,4.681,4.681,0,0,1-.192,1.349,5.046,5.046,0,0,1-.534,1.2,5.082,5.082,0,0,1-.813,1.01A5.323,5.323,0,0,1,43.313-13l2.663,5.042q.073.146.186.344a.716.716,0,0,1,.114.344.31.31,0,0,1-.109.255.454.454,0,0,1-.3.089H42.318A.516.516,0,0,1,42-7.03a.473.473,0,0,1-.181-.281L39.3-12.071H37.625v4.7q0,.448-.477.448H34.071a.484.484,0,0,1-.332-.109.428.428,0,0,1-.124-.339ZM41.5-17.29a1.813,1.813,0,0,0-.114-.625,2.033,2.033,0,0,0-.321-.573,1.884,1.884,0,0,0-.5-.437,1.7,1.7,0,0,0-.642-.229l-.544-.036q-.254-.016-.554-.016h-1.2v3.823H39.3q.186,0,.332-.01t.321-.031a1.63,1.63,0,0,0,.653-.214,1.7,1.7,0,0,0,.487-.427,1.889,1.889,0,0,0,.3-.573A2.087,2.087,0,0,0,41.5-17.29Zm20,2.646a7.719,7.719,0,0,1-.28,2.1,7.512,7.512,0,0,1-.8,1.854,7.685,7.685,0,0,1-1.238,1.557,7.643,7.643,0,0,1-1.6,1.187,8.008,8.008,0,0,1-1.891.755,8.277,8.277,0,0,1-2.1.266H48.483a.654.654,0,0,1-.332-.083.375.375,0,0,1-.145-.354V-21.915a.516.516,0,0,1,.119-.354.451.451,0,0,1,.357-.135h5.108a8.068,8.068,0,0,1,2.1.271,7.919,7.919,0,0,1,1.886.771,8.075,8.075,0,0,1,1.6,1.2A7.394,7.394,0,0,1,60.414-18.6a7.857,7.857,0,0,1,.8,1.865A7.6,7.6,0,0,1,61.5-14.644Zm-9.48-4.021v8.01l.653.016q.238,0,.466-.016t.456-.036a4.15,4.15,0,0,0,1.451-.38,4.022,4.022,0,0,0,1.176-.833,3.748,3.748,0,0,0,.787-1.214,3.986,3.986,0,0,0,.285-1.521,3.918,3.918,0,0,0-.326-1.609,3.979,3.979,0,0,0-.886-1.271,3.992,3.992,0,0,0-1.311-.833,4.316,4.316,0,0,0-1.6-.3ZM64.2-21.915a.5.5,0,0,1,.119-.349.432.432,0,0,1,.336-.13H74.935a.455.455,0,0,1,.352.135.516.516,0,0,1,.124.364v2.576a.545.545,0,0,1-.124.338.43.43,0,0,1-.363.161H68.211v2.583h5.181a.542.542,0,0,1,.326.094.36.36,0,0,1,.13.312v2.25a.433.433,0,0,1-.114.281.409.409,0,0,1-.332.135H68.211V-10.5h6.963a.417.417,0,0,1,.466.478V-7.4a.258.258,0,0,1-.083.187q-.041.291-.425.291H64.656a.482.482,0,0,1-.331-.109.428.428,0,0,1-.124-.339Zm14.029-.021a.485.485,0,0,1,.114-.323.422.422,0,0,1,.342-.135h3.388a.706.706,0,0,1,.3.073.657.657,0,0,1,.269.25q1.316,2.135,2.611,4.208t2.621,4.208V-22a.51.51,0,0,1,.166-.292.438.438,0,0,1,.29-.1h2.953a.551.551,0,0,1,.363.12.414.414,0,0,1,.145.339v14.6a.369.369,0,0,1-.124.307.535.535,0,0,1-.342.1H88.021a.345.345,0,0,1-.238-.094,1.647,1.647,0,0,1-.218-.25L84.84-11.8q-1.347-2.24-2.735-4.531v8.948a.5.5,0,0,1-.1.344.49.49,0,0,1-.373.115H78.686a.428.428,0,0,1-.347-.13.479.479,0,0,1-.109-.318Z" transform="translate(14.146 36.836)"/></g></svg>
            </a>
        </div>
        <div class="nav-menu">
            <ul>
                <li><a href="/#shop_product">SHOP PRODUCT</a></li>
                <li><a href="/#benefits">BENEFITS</a></li>
                <li><a href="/#faq">FAQ</a></li>
                <li><a href="/#review">REVIEW</a></li>
            </ul>
            <div class="shopping_cart">
                <a href="{{ route('public.cart') }}" class="navbar_cart_link">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="24" viewBox="0 0 28 24"><defs><style>.a{fill:#fff;}</style></defs><g transform="translate(-812.223 1235.726)"><path class="a" d="M828.791-1216.237q-3.256,0-6.511,0a2.518,2.518,0,0,1-2.705-2.313q-1.369-7.461-2.76-14.918c-.1-.513-.121-.53-.65-.531-1,0-2.005.008-3.008-.008a.853.853,0,0,1-.85-1.205.794.794,0,0,1,.755-.5c1.18-.007,2.36-.03,3.538.01a1.881,1.881,0,0,1,1.8,1.55q.26,1.149.458,2.311c.043.25.148.3.373.3q6.476-.009,12.952-.005c1.817,0,3.633,0,5.45,0a2.477,2.477,0,0,1,2.514,3.2q-1.108,5.02-2.21,10.042a2.463,2.463,0,0,1-2.559,2.061C833.179-1216.233,830.985-1216.237,828.791-1216.237Zm-9.481-13.592c.013.113.017.183.03.252.175.946.357,1.891.524,2.839.471,2.661.935,5.324,1.406,7.986.106.6.34.8.937.8q6.583,0,13.165,0c.585,0,.811-.183.938-.758q1.1-4.987,2.193-9.974c.162-.737-.143-1.12-.889-1.121l-17.908-.02Z" transform="translate(0)"/><path class="a" d="M911.143-1019a1.73,1.73,0,0,1,1.731-1.755,1.751,1.751,0,0,1,1.741,1.719,1.751,1.751,0,0,1-1.741,1.755A1.733,1.733,0,0,1,911.143-1019Z" transform="translate(-89.612 -194.442)"/><path class="a" d="M1032.734-1019.029a1.728,1.728,0,0,1-1.722,1.762,1.741,1.741,0,0,1-1.744-1.711,1.748,1.748,0,0,1,1.732-1.761A1.72,1.72,0,0,1,1032.734-1019.029Z" transform="translate(-196.731 -194.459)"/></g></svg>
                    <span class="cart_itemCount">{{ Cart::instance('cart')->count() }}</span>
                </a>
            </div>
            <button class="menu-toggle" aria-controls="site-navigation" aria-expanded="false"><span></span></button>
        </div>
    </div>
</nav>
@endif
