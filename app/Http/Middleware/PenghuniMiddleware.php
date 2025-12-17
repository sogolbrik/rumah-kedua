<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PenghuniMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            if (Auth::user()->role == 'penghuni') {
                return $next($request);
            } else {
                session()->put('url.intended', url()->current());

                return redirect()->back()->with('error', 'Anda tidak memiliki akses ke halaman ini!');
            }
        }
        return redirect()->back()->with('error', 'Anda tidak memiliki akses ke halaman ini!');
    }
}
