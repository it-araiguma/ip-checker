<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class IndexController extends Controller
{
    public function index(Request $request)
    {
        $ip = $request->ip();
        $host = gethostname();
        $userAgent = $request->userAgent();

        return Inertia::render('Index', ['ip' => $ip, 'host' => $host, 'userAgent' => $userAgent]);
    }
}
