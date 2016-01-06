<!DOCTYPE html>
@section('html-tag')<html>@show
<head>
    <meta charset="utf-8" />
    <link rel="icon" href="/favicon.ico" type="image/vnd.microsoft.icon">

    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.1/css/materialize.min.css">
    <!-- Let browser know website is optimized for mobile -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="style.css" rel="stylesheet" />
    <title>@section('title') MyGrades @show</title>
</head>

<body>
@yield('content')
</body>
</html>
