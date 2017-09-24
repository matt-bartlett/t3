<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=0">
    <title>{{ config('app.name') }}</title>
    <style>
        @import url('https://fonts.googleapis.com/css?family=Montserrat:300,400,500');
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Montserrat', sans-serif;
            font-weight: 100;
            height: 100vh;
            margin: 0;
        }
        .full-height {
            height: 100vh;
        }
        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }
        .content {
            text-align: center;
        }
        .title {
            margin: 0;
            font-size: 84px;
        }
    </style>
</head>
<body>
    @yield('content')
</body>
</html>
