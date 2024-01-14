<!DOCTYPE html>
<html>

<head>
    @if (config('app.env') === 'production')
        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-XFR2JYLS4T"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());

            gtag('config', 'G-XFR2JYLS4T');
        </script>
    @endif
    <title>IPチェッカー | IPアドレス、ホスト、ユーザーエージェントのチェックツール</title>
    <meta name="description" content="IPチェッカーはIPアドレス、ホスト、ユーザーエージェントのチェックができる便利ツールです。">
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <link rel="icon" href="{{ asset('images/favicon.ico') }}">
    @inertiaHead
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    @inertia
</body>

</html>
