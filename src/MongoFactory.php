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
namespace Nasustop\HapiMongo;

use Hyperf\Contract\ConfigInterface;
use Nasustop\HapiMongo\Exception\InvalidConnectionException;

class MongoFactory
{
    /**
     * @var MongoProxy[]
     */
    protected array $proxies = [];

    public function __construct(ConfigInterface $config)
    {
        $memcachedConfig = $config->get('memcached');

        foreach ($memcachedConfig as $poolName => $item) {
            $this->proxies[$poolName] = make(MongoProxy::class, ['pool' => $poolName]);
        }
    }

    public function get(string $poolName): MongoProxy
    {
        $proxy = $this->proxies[$poolName] ?? null;
        if (! $proxy instanceof MongoProxy) {
            throw new InvalidConnectionException('Invalid Memcached proxy.');
        }

        return $proxy;
    }
}
