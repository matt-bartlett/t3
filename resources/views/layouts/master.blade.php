<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link href="/css/app.css" rel="stylesheet">
    <link href="/css/main.css" rel="stylesheet">
    <title>{{ config('app.name') }}</title>
</head>
<body>

    @yield('banner')

    @yield('content')

    @include('partials/footer')

</body>
</html>
