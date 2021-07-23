<!DOCTYPE html>
<html lang="kr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Lalavel')</title>
</head>
<body>
    <h1>@yield('title')</h1>
    @yield('content')
</body>
</html>