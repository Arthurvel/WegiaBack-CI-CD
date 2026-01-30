<?php

namespace Modules\ContribuicaoSocios\app\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\IpUtils;

class PagarmeIpMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $ipsPermitidos = config('gateways.pagarme.allowed_ips');

        if (!empty($ipsPermitidos)) {
            if (!IpUtils::checkIp($request->ip(), $ipsPermitidos)) {
                abort(403, 'IP não autorizado');
            }
        }

        return $next($request);
    }
}
