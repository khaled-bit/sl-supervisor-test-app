<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Supervisor XML-RPC Endpoint
    |--------------------------------------------------------------------------
    |
    | The XML-RPC endpoint URL for your supervisor instance.
    | Default: http://127.0.0.1:9001/RPC2
    |
    */
    'endpoint' => env('SUPERVISOR_XMLRPC_ENDPOINT', 'http://127.0.0.1:9001/RPC2'),

    /*
    |--------------------------------------------------------------------------
    | Supervisor Username
    |--------------------------------------------------------------------------
    |
    | Optional username for basic authentication with supervisor.
    |
    */
    'username' => env('SUPERVISOR_USERNAME'),

    /*
    |--------------------------------------------------------------------------
    | Supervisor Password
    |--------------------------------------------------------------------------
    |
    | Optional password for basic authentication with supervisor.
    |
    */
    'password' => env('SUPERVISOR_PASSWORD'),
];
