<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
  </head>
  <body class="antialiased">
    <div class="page">
      @include('layouts.navbar')

      <div class="page-wrapper">
        @include('layouts.sidebar')

        <main class="page-body">
          <div class="container-xl">
            @yield('content')
          </div>
        </main>
      </div>
    </div>
  </body>
</html>
