<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class IndexController extends Controller
{
    public function index(Request $request)
    {
        $ip = $request->ip();
        $host = gethostbyaddr($ip);
        $userAgent = $request->userAgent();

        return Inertia::render('Index', ['ip' => $ip, 'host' => $host, 'user_agent' => $userAgent]);
    }

    public function privacy()
    {
        return Inertia::render('Privacy');
    }
}
