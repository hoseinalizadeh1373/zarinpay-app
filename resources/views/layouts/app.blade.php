<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title','سامانه پرداخت')</title>
    @vite(['resources/js/app.js'])
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container">
    <a class="navbar-brand" href="{{ url('/') }}">سامانه پرداخت</a>
  </div>
</nav>

<main class="container py-4">
  @yield('content')
</main>

<footer class="bg-dark text-white text-center py-3 mt-5">
  <small>© {{ date('Y') }} تمامی حقوق محفوظ است</small>
</footer>

</body>
</html>
