<?php

return [
    'name' => 'ContribuicaoSocios',

    'gateways' => [
        'pagarme' => [
            'base_url'   => env('PAGARME_BASE_URL', 'https://api.pagar.me/core/v5'),
            'private_key' => env('PRIVATE_KEY_PAGAR_ME'),
            'allowed_ips' => array_filter(
                explode(',', env('ALLOWED_IPS_PAGAR_ME', ''))
            )
        ],
    ],

    'titulo_email' => env('MAIL_FROM_NAME', '')

];
