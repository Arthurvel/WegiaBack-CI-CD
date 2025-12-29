<?php

namespace Modules\ContribuicaoSocios\app\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PagarmeHmacMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $secret = config('gateways.pagarme.private_key');

        if (!$secret) {
            abort(500, 'Webhook secret não configurado');
        }

        $signature = $request->header('X-Hub-Signature-256')
            ?? $request->header('X-Hub-Signature');

        if (!$signature) {
            abort(401, 'Assinatura HMAC ausente');
        }

        $signature = str_replace('sha256=', '', $signature);

        $payload = $request->getContent();

        $expected = hash_hmac('sha256', $payload, $secret);

        if (!hash_equals($expected, $signature)) {
            abort(401, 'HMAC inválido');
        }

        return $next($request);
    }
}
