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
        $ipv4 = null;
        $ipv6 = null;

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
        $userAgent = $request->header('User-Agent');
        $xRequestedWith = $request->header('X-Requested-With');
        $referer = $request->header('Referer');

        return strpos($userAgent, 'Android') !== false
            && strpos($userAgent, 'Chrome/') !== false
            && strpos($userAgent, 'Version/') === false
            && $xRequestedWith === 'com.google.android.twa.launcher'
            && strpos($referer, 'android-app://') === 0;
    }
}
