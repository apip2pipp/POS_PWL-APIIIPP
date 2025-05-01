<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthorizeUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $req, Closure $next, ... $roles): Response
    {
        $user_role = $req->user()->getRole();

        if (in_array($user_role, $roles)) {
            return $next($req);
        }
        
        abort(Response::HTTP_FORBIDDEN, 'NGAWOT! AKSES ANDA EROR DAN TIDAK BOLEH MENGAKSES HALAMAN INI');
    }
}