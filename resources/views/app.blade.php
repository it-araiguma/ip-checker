<!DOCTYPE html>
<html>

<head prefix="og:http://ogp.me/ns#">
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
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta property="og:title" content="IPチェッカー | IPアドレス、ホスト、ユーザーエージェントのチェックツール" />
    <meta property="og:description" content="IPチェッカーはIPアドレス、ホスト、ユーザーエージェントのチェックができる便利ツールです。" />
    <meta property="og:url" content="{{ config('app.url') }}"/>
    <meta property="og:image" content="{{ asset('images/logo.png') }}" />
    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="IPチェッカー" />
    <meta name="twitter:card" content="summary" />
    <meta name="twitter:site" content="@it_araiguma">
    @inertiaHead
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    @inertia
</body>

</html>
