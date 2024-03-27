<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width">

        <title inertia>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <style>
          /* Hide scrollbar for Chrome, Safari and Opera */
          body::-webkit-scrollbar {
            display: none;
          }

          /* Hide scrollbar for IE, Edge and Firefox */
          body {
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;  /* Firefox */
          }
        </style>

  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">

  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />
  <script async defer src="https://cdn.jsdelivr.net/npm/jkanban@1.3.1/dist/jkanban.min.js"></script>
        <!-- Scripts -->
        @vite(['resources/js/main.js'])
    </head>
    <body class="bg-gray-100">
        <div id="app">
          <div id="loading-bg">
            <div class="loading-logo">
              <!-- SVG Logo -->

            </div>
            <div class=" loading">
              <div class="effect-1 effects"></div>
              <div class="effect-2 effects"></div>
              <div class="effect-3 effects"></div>
            </div>
          </div>
        </div>
    {{-- <body class="font-sans antialiased">

    </body> --}}
</html>
