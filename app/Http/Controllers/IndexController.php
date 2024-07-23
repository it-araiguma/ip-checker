<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use GeoIp2\Database\Reader;

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
            $reader = new Reader(storage_path('app/geoip/GeoLite2-Country.mmdb'));
            try {
                $record = $reader->country($ipv4);
                $country = $record->country->name;
            } catch (\Exception $e) {
                $country = 'Unknown';
            }
        }

        return Inertia::render('Index', [
            'ipv4' => $ipv4,
            'ipv6' => $ipv6,
            'host' => $host,
            'user_agent' => $userAgent,
            'country' => $country,
        ]);
    }

    public function privacy()
    {
        return Inertia::render('Privacy');
    }
}
