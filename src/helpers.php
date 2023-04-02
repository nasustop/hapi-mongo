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
if (! function_exists('mongo')) {
    /**
     * 获取memcached连接.
     */
    function mongo(string $pool = 'default'): Nasustop\HapiMongo\MongoProxy
    {
        try {
            return \Hyperf\Utils\ApplicationContext::getContainer()->get(\Nasustop\HapiMongo\MongoFactory::class)->get($pool);
        } catch (\Psr\Container\NotFoundExceptionInterface|\Psr\Container\ContainerExceptionInterface $e) {
            return make(\Nasustop\HapiMongo\MongoFactory::class)->get($pool);
        }
    }
}
