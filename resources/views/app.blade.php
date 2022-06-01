<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title inertia>{{ config('app.name', 'Laravel') }}</title>

  <!-- Fonts -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,200;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400&display=swap"
    rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
  <!-- Styles -->
  <link rel="stylesheet" href="{{ mix('css/app.css') }}">

  <!-- Scripts -->
  @routes
  <script src="{{ mix('js/app.js') }}" defer></script>
  @inertiaHead
</head>

<body class="font-sans antialiased  w-screen h-screen">
  @inertia

  @env ('local')
  <script src="http://localhost:8080/js/bundle.js"></script>
  @endenv
</body>

</html>