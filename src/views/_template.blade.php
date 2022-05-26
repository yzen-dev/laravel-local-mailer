<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="LocalMailer">
    <meta name="author" content="yzen.dev">
    <title>Local Mailer</title>
    {{-- Styles --}}
    <link href="/local-mailer/resource/css/styles.css" rel="stylesheet">
</head>
<body>

<div class="container">
    @yield('content')

    {{--<footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
        <p class="mb-0 text-muted">
            LocalMailer - <span class="badge bg-info text-dark">version 0.1</span>
        </p>

        <div class="justify-content-end">
            yzen.dev <sup>&copy;</sup>
        </div>
    </footer>--}}
</div>

</body>
</html>
