<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('packageName')</title>
    <style type="text/css">
        .container { width:1200px; margin:0 auto; overflow: hidden; }
        #packages { width:220px; }
        #readme { width:980px; }
        #packages, #readme { float:left; }
        .inner-content { padding:45px 0; }
        .entry-content { padding:45px; }
        @include('readme::css')
    </style>
</head>
<body>
<div class="container markdown-body">
    <div id="packages">
        <div class="inner-content">
            @yield('packageList')
        </div>
    </div>

    <div id="readme">
        <div class="entry-content">
            @yield('docs')
        </div>
    </div>
</div>
</body>
</html>