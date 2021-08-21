<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{config('app.name')}}</title>
    <link href="https://uploads-ssl.webflow.com/60590851dbb9ac7f8483c542/6059abc52624d8201dd1b25b_favicon_32x32.png"
          rel="shortcut icon" type="image/x-icon"/>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('custom.css')}}">
    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
    </style>
    @stack('css')
</head>
<body class="antialiased">
<div id="app">

    @include('partials.navbar')

    <main class="py-4 my-4">
        @yield('content')
    </main>

    @include('partials.footer')

</div>
</body>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{mix('js/vendor.js')}}"></script>
<script src="{{mix('js/manifest.js')}}"></script>
<script src="{{mix('js/app.js')}}"></script>
@stack('js')
</html>
