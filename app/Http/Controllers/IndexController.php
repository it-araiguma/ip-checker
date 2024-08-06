<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use GeoIp2\Database\Reader;
use GeoIp2\Exception\AddressNotFoundException;

class IndexController extends Controller
{
    public function index(Request $request)
    {
        $ips = $request->getClientIps();
        $ipv4 = '';
        $ipv6 = '';

        foreach ($ips as $ip) {
            if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
                $ipv4 = $ip;
            } elseif (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
                $ipv6 = $ip;
            }
        }

        $host = gethostbyaddr($ip);
        $userAgent = $request->userAgent();

        $country = null;
        if ($ipv4) {
            $reader = new Reader(storage_path('app/geoip/GeoLite2-City.mmdb'));
            try {
                $record = $reader->city($ipv4);
                $country = $record->country->name;
                $city = $record->city->name;
            } catch (AddressNotFoundException $e) {
                $country = 'Unknown';
                $city = 'Unknown';
            }
        }

        return Inertia::render('Index', [
            'ipv4' => $ipv4,
            'ipv6' => $ipv6,
            'host' => $host,
            'user_agent' => $userAgent,
            'country' => $country,
            'city' => $city,
            'is_twa' => $this->isTWA($request),
        ]);
    }

    public function privacy()
    {
        return Inertia::render('Privacy');
    }

    private function isTWA(Request $request)
    {
        // クライアントサイドで設定したカスタムヘッダーをチェック
        $isTwaHeader = $request->header('X-Is-TWA');
        if ($isTwaHeader === 'true') {
            return true;
        }

        // User-Agentの確認
        $userAgent = $request->header('User-Agent');
        $isAndroidChrome = strpos($userAgent, 'Android') !== false
            && strpos($userAgent, 'Chrome/') !== false
            && strpos($userAgent, 'Version/') === false;

        if (!$isAndroidChrome) {
            return false;
        }

        // Referrerの確認
        $referer = $request->header('Referer');
        $hasAndroidAppReferer = strpos($referer, 'android-app://') === 0;

        // X-Requested-Withの確認
        $xRequestedWith = $request->header('X-Requested-With');
        $hasTwaLauncher = $xRequestedWith === 'com.google.android.twa.launcher';

        // カスタムクエリパラメータの確認
        $twaParam = $request->query('twa');

        return $hasAndroidAppReferer || $hasTwaLauncher || $twaParam === 'true';
    }
}
