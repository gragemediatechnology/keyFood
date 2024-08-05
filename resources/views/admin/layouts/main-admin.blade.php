<!DOCTYPE html>
<html :class="{ 'theme-dark': dark }" class="overflow-hidden" x-data="data()" lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Windmill Dashboard</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('./assets/css/tailwind.output.css') }}" />
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
  <script src="{{ asset('./assets/js/init-alpine.js') }}"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js" defer></script>
  <script src="{{ asset('./assets/js/charts-lines.js') }}" defer></script>
  <script src="{{ asset('./assets/js/charts-pie.js') }}" defer></script>
</head>

<body>
    @include('admin.partials.sidebar-admin')
    <div class="container-admin" id="container-admin">
        @yield('container-admin')
    </div>

</body>

</html>