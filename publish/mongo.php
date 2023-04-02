<?php

declare(strict_types=1);
/**
 * This file is part of Hapi.
 *
 * @link     https://www.nasus.top
 * @document https://wiki.nasus.top
 * @contact  xupengfei@xupengfei.net
 * @license  https://github.com/nasustop/hapi-mongo/blob/master/LICENSE
 */
return [
    'default' => [
        'host' => env('MONGO_HOST', 'localhost'),
        'port' => (int) env('MONGO_PORT', 27017),
        'username' => env('MONGO_USERNAME', 'hapi'),
        'password' => env('MONGO_PASSWORD', '123456'),
        'database' => env('MONGO_DATABASE', 'hapi'),
        'pool' => [
            'min_connections' => swoole_cpu_num(),
            'max_connections' => swoole_cpu_num() * 2,
            'connect_timeout' => 10.0,
            'wait_timeout' => 3.0,
            'heartbeat' => -1,
            'max_idle_time' => (float) env('MONGO_MAX_IDLE_TIME', 60),
        ],
    ],
];
