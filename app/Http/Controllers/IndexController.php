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

        // ブラウザと OS 情報の取得
        $browserInfo = $this->getBrowserInfo($userAgent);
        
        // HTTP ヘッダー情報の取得
        $headers = $this->getRequestHeaders($request);
        
        // 接続情報の取得
        $connectionInfo = [
            'protocol' => $request->secure() ? 'HTTPS' : 'HTTP',
            'method' => $request->method(),
            'port' => $request->getPort(),
            'is_secure' => $request->secure(),
            'is_ajax' => $request->ajax(),
        ];

        $country = null;
        $city = null;
        $timezone = null;
        $isp = '';  // 空文字列に初期化
        
        if ($ipv4) {
            $reader = new Reader(storage_path('app/geoip/GeoLite2-City.mmdb'));
            try {
                $record = $reader->city($ipv4);
                $country = $record->country->name;
                $city = $record->city->name;
                $timezone = $record->location->timeZone;
                
                // 可能であれば ISP 情報も取得
                if (isset($record->traits->isp)) {
                    $isp = $record->traits->isp;
                }
            } catch (AddressNotFoundException $e) {
                $country = 'Unknown';
                $city = 'Unknown';
                $timezone = 'Unknown';
            }
        }

        return Inertia::render('Index', [
            'ipv4' => $ipv4,
            'ipv6' => $ipv6,
            'host' => $host,
            'user_agent' => $userAgent,
            'country' => $country,
            'city' => $city,
            'timezone' => $timezone,
            'isp' => $isp,
            'browser_info' => $browserInfo,
            'headers' => $headers,
            'connection_info' => $connectionInfo,
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
    
    /**
     * ユーザーエージェント文字列からブラウザとOS情報を取得
     */
    private function getBrowserInfo($userAgent)
    {
        $browser = 'Unknown';
        $os = 'Unknown';
        $device = 'Unknown';
        
        // ブラウザ判定
        if (preg_match('/MSIE|Trident/i', $userAgent)) {
            $browser = 'Internet Explorer';
        } elseif (preg_match('/Firefox/i', $userAgent)) {
            $browser = 'Firefox';
        } elseif (preg_match('/Chrome/i', $userAgent) && !preg_match('/Edg/i', $userAgent)) {
            $browser = 'Chrome';
        } elseif (preg_match('/Safari/i', $userAgent) && !preg_match('/Chrome/i', $userAgent)) {
            $browser = 'Safari';
        } elseif (preg_match('/Edg/i', $userAgent)) {
            $browser = 'Edge';
        } elseif (preg_match('/Opera|OPR/i', $userAgent)) {
            $browser = 'Opera';
        }
        
        // OS判定
        if (preg_match('/Windows/i', $userAgent)) {
            $os = 'Windows';
            if (preg_match('/Windows NT 10.0/i', $userAgent)) {
                $os .= ' 10';
            } elseif (preg_match('/Windows NT 6.3/i', $userAgent)) {
                $os .= ' 8.1';
            } elseif (preg_match('/Windows NT 6.2/i', $userAgent)) {
                $os .= ' 8';
            } elseif (preg_match('/Windows NT 6.1/i', $userAgent)) {
                $os .= ' 7';
            }
        } elseif (preg_match('/Macintosh|Mac OS X/i', $userAgent)) {
            $os = 'Mac OS';
        } elseif (preg_match('/Linux/i', $userAgent)) {
            $os = 'Linux';
        } elseif (preg_match('/Android/i', $userAgent)) {
            $os = 'Android';
        } elseif (preg_match('/iPhone|iPad|iPod/i', $userAgent)) {
            $os = 'iOS';
        }
        
        // デバイス判定
        if (preg_match('/Mobile|Android|iPhone|iPad|iPod/i', $userAgent)) {
            $device = 'Mobile';
            if (preg_match('/tablet|iPad/i', $userAgent)) {
                $device = 'Tablet';
            }
        } else {
            $device = 'Desktop';
        }
        
        return [
            'browser' => $browser,
            'os' => $os,
            'device' => $device,
        ];
    }
    
    /**
     * リクエストから主要なHTTPヘッダーを取得
     */
    private function getRequestHeaders(Request $request)
    {
        $headers = [];
        $importantHeaders = [
            'Accept-Language',
            'Referer',
            'Accept-Encoding',
            'Accept',
            'Connection',
            'Cache-Control',
            'DNT', // Do Not Track
            'Upgrade-Insecure-Requests',
            'Sec-Fetch-Dest',
            'Sec-Fetch-Mode',
            'Sec-Fetch-Site',
            'Sec-Fetch-User',
        ];
        
        foreach ($importantHeaders as $header) {
            if ($request->header($header)) {
                $headers[$header] = $request->header($header);
            }
        }
        
        return $headers;
    }
}
