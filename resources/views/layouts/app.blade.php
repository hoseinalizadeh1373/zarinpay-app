<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title','سامانه پرداخت')</title>

    <!-- Bootstrap icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!-- فونت ایران‌سانس -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/iransans-fontface@0.1.1/css/iransans-fontface.min.css">

    <!-- فایل‌های CSS و JS پروژه (Vite) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container">
    <a class="navbar-brand" href="{{ url('/') }}">سامانه ثبت نام دوره های متینه روحی</a>
  </div>
</nav>

<main class="container py-4">
  @yield('content')
</main>

</body>
</html>
