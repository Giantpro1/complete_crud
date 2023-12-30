<?php
return [
    // ... other configurations

    /*
    |--------------------------------------------------------------------------
    | Default Cache Driver
    |--------------------------------------------------------------------------
    |
    | Here you may specify the type of caching that should be used
    | by the package.
    |
    | Options:
    |
    |  all  - All location are cached
    |  some - Cache only the requesting user
    |  none - Disable cached
    |
    */

    'cache' => [
        'store' => 'file', // or 'redis' or any other cache store that supports tagging
        'expire' => 60, // Cache lifetime in minutes
    ],

    // ... other configurations
];
