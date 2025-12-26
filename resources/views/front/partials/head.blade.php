<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="zxx">

<head>
    <meta charset="UTF-8">
    {{-- <meta name="google-site-verification" content="aXqrgB3z78lfk6xm4FJfjDYL0u96-f8gHXVWuDY-ORY"/> --}}

    <meta name="description"
        content="Find best deals at FlightsGyani for ✅ Flight Tickets, Hotels, Holiday Packages Reservations for Nepal  & International travel" />
    <meta name="csrf_token" content="{{ csrf_token() }}">
    <meta name="keywords"
        content="Hotels package reservations, International holiday package from nepal, Europe Package from Nepal,Thailand package from Nepal,Best Travel Agency in Nepal,Best Travel Agency for International Holidays,International Hotel booking Service in Nepal,USA package from Nepal,Singapore Malaysia Package from Nepal,bali Package from Nepal, cheap Flights Ticket in Nepal ,Australia package from Nepal,Maldives package from Nepal,Dubai Package from Nepal, Mauritius Package from Nepal,Vietnam Cambodia Package from Nepal,India Package from NepalChina Package from nepal,japan package from nepal,Baku Package from Nepal,Korea Package from Nepal,Egypt Package from Nepal, South Africa Package from Nepal,UK Package from Nepal" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="google-site-verification" content="qS-U6jkDqS_h0sUvgYaXgHMAHRmlxkwYi1cb12rbLcY" />
    <title>{{ isset($site->name) ? $site->name : 'FlightsGyani' }}
        - {{ isset($site->title) ? $site->title : 'Nepal # 1 Travel for Online Flights, Hotels & Holidays.' }}</title>

    @yield('meta')
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('frontend/images/fab-icon.png') }}">

    {{-- New Styles --}}
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />

    <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.0/themes/base/jquery-ui.css" />
    <!-- <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css"> -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet" type="text/css">

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-5WB97JLE6K"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-5WB97JLE6K');
    </script>

    <!-- Load Facebook SDK for JavaScript -->
    <div id="fb-root"></div>
    <script>
        window.fbAsyncInit = function() {
            FB.init({
                xfbml: true,
                version: 'v8.0'
            });
        };

        (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s);
            js.id = id;
            js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>

    <!-- Your Chat Plugin code -->
    <div class="fb-customerchat" attribution=setup_tool page_id="2164287780515821" theme_color="#CA1118">
    </div>
    <script>
        var isNS = (navigator.appName == "Netscape") ? 1 : 0;

        if (navigator.appName == "Netscape") document.captureEvents(Event.MOUSEDOWN || Event.MOUSEUP);

        function mischandler() {
            return false;
        }

        function mousehandler(e) {
            var myevent = (isNS) ? e : event;
            var eventbutton = (isNS) ? myevent.which : myevent.button;
            if ((eventbutton == 2) || (eventbutton == 3)) return false;
        }
        document.oncontextmenu = mischandler;
        document.onmousedown = mousehandler;
        document.onmouseup = mousehandler;
    </script>
    <!-- Facebook Pixel Code -->
    <script>
        ! function(f, b, e, v, n, t, s) {
            if (f.fbq) return;
            n = f.fbq = function() {
                n.callMethod ?
                    n.callMethod.apply(n, arguments) : n.queue.push(arguments)
            };
            if (!f._fbq) f._fbq = n;
            n.push = n;
            n.loaded = !0;
            n.version = '2.0';
            n.queue = [];
            t = b.createElement(e);
            t.async = !0;
            t.src = v;
            s = b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t, s)
        }(window, document, 'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '363422097763765');
        fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
            src="https://www.facebook.com/tr?id=363422097763765&ev=PageView&noscript=1" /></noscript>
    <!-- End Facebook Pixel Code -->

    <script src="https://www.google.com/recaptcha/api.js"></script>
    <script>
        function onSubmit(token) {
            document.getElementById("contactForm").submit();
        }
    </script>
    @yield('styles')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script src='https://www.google.com/recaptcha/api.js'></script>
    @livewireStyles
</head>
