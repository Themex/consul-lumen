<?php

return [
    /*
     * Consul HTTP
     */
    'base_uris' => [
        env('CONSUL_HTTP_ADDR', 'http://127.0.0.1:8500')
    ],

    /*
     * Consul Services list to register
     */
    'services' => [
        [
            'Name' => env('CONSUL_SERVICE_NAME'),
            'ID' => env('CONSUL_SERVICE_ID'),
            'Tags' => [
                env('CONSUL_SERVICE_TAG')
            ],
            'Address' => env('CONSUL_SERVICE_ADDRESS'),
            'Port' => (int) env('CONSUL_SERVICE_PORT'),
            'EnableTagOverride' => false,
            'Check' => [
                'DeregisterCriticalServiceAfter' => '90m',
                'Tcp' => env('CONSUL_SERVICE_ADDRESS').':'.env('CONSUL_SERVICE_PORT'),
                'Interval' => '10s',
                'Timeout' => '5s'
            ]
        ]
    ]
];
