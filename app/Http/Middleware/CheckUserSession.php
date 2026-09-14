<?php

namespace App\Http\Middleware;

use App\Services\SsoService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class CheckUserSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$role)
    {
        if (!$request->session()->exists('user')) {
            $ssoUrl = env('SSO_URL', 'http://localhost:9000');
            return redirect(rtrim($ssoUrl, '/') . '/login')->with('resp_msg', 'Your session has expired');
        }

        // Validate SSO token if present (cached for 30s for quick single-logout detection)
        $ssoToken = session('sso_token');
        if ($ssoToken) {
            $cacheKey = 'sso_sijawara_token_' . hash('sha256', $ssoToken);
            $isValid = Cache::remember($cacheKey, now()->addSeconds(30), function () use ($ssoToken) {
                $ssoService = new SsoService();
                $result = $ssoService->getUser($ssoToken);
                return $result['success'] ?? false;
            });

            if (!$isValid) {
                Cache::forget($cacheKey);
                Session::forget(['user', 'sso_token', 'sso_user']);
                Session::flush();
                $request->session()->invalidate();
                $ssoUrl = env('SSO_URL', 'http://localhost:9000');
                return redirect(rtrim($ssoUrl, '/') . '/login')->with('resp_msg', 'Sesi SSO Anda telah berakhir. Silakan login kembali.');
            }
        }

        if (empty($role) || in_array(session('user')[0]['ID_ROLE'], $role)) {
            return $next($request);
        } else {
            return redirect('');
        }
    }
}
