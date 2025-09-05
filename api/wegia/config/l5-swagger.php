<?php

return [
    'default' => 'default',
    'documentations' => [
        'default' => [
            'api' => [
                'title' => 'Api Default',
            ],
            'routes' => [
                'docs' => 'docs',
                'api' => 'api/documentation',
                'oauth2_callback' => 'api/teste'
            ],
            'paths' => [
                'docs' => storage_path('api-docs'),
                'use_absolute_path' => env('L5_SWAGGER_USE_ABSOLUTE_PATH', true),

                'docs_json' => 'api-docs.json',
                'docs_yaml' => 'api-docs.yaml',
                'format_to_use_for_docs' => env('L5_FORMAT_TO_USE_FOR_DOCS', 'json'),

                'annotations' => [
                    base_path('app'),
                ],
            ],
        ],

        'memorando' => [
            'api' => [
                'title' => 'API Memorando',
            ],
            'routes' => [
                'api' => 'api/memorando/documentation',
                'docs' => 'api/memorando/docs'
            ],
            'paths' => [
                'docs' => storage_path('memorando-api-docs'),

                'use_absolute_path' => env('L5_SWAGGER_USE_ABSOLUTE_PATH', true),

                'docs_json' => 'memorando-api-docs.json',
                'docs_yaml' => 'memorando-api-docs.yaml',
                'format_to_use_for_docs' => env('L5_FORMAT_TO_USE_FOR_DOCS', 'json'),

                'annotations' => [
                    base_path('Modules/Memorando'),
                ],
            ],
        ],

        'material' => [
            'api' => [
                'title' => 'API Material',
            ],
            'routes' => [
                'api' => 'api/material/documentation',
                'docs' => 'api/material/docs'
            ],
            'paths' => [
                'docs' => storage_path('material-api-docs'),

                'use_absolute_path' => env('L5_SWAGGER_USE_ABSOLUTE_PATH', true),

                'docs_json' => 'material-api-docs.json',
                'docs_yaml' => 'material-api-docs.yaml',
                'format_to_use_for_docs' => env('L5_FORMAT_TO_USE_FOR_DOCS', 'json'),

                'annotations' => [
                    base_path('Modules/Material'),
                ],
            ],
        ],

        'pet' => [
            'api' => [
                'title' => 'API Pet',
            ],
            'routes' => [
                'api' => 'api/pet/documentation',
                'docs' => 'api/pet/docs'
            ],
            'paths' => [
                'docs' => storage_path('pet-api-docs'),

                'use_absolute_path' => env('L5_SWAGGER_USE_ABSOLUTE_PATH', true),

                'docs_json' => 'pet-api-docs.json',
                'docs_yaml' => 'pet-api-docs.yaml',
                'format_to_use_for_docs' => env('L5_FORMAT_TO_USE_FOR_DOCS', 'json'),

                'annotations' => [
                    base_path('Modules/Pet'),
                ],
            ],
        ],
    ],
];
