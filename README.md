# HapiMongo
hyperf的mongo协程组件

现阶段 Swoole 暂时没有办法 hook 所有的阻塞函数，也就意味着有些函数仍然会导致 进程阻塞，从而影响协程的调度
因为 MongoDB 没有办法被 hook，所以当前项目会阻塞进程，请谨慎使用
参考文档:https://hyperf.wiki/3.0/#/zh-cn/task

生产环境使用mongo请参考hapi-sidecar边车服务

## 安装
```shell
composer require nasustop/hapi-mongo
```

## 声称配置文件
```shell
php bin/hyperf.php vendor:publish nasustop/hapi-mongo
```

## 添加索引
```php
mongo()->cmd([
    // 集合名
    'createIndexes' => 'api_log',
    'indexes' => [
        [
            // 索引名
            'name' => 'msg_code_index',
            // 索引字段数组[1升序，-1降序]
            'key' => ['msg_code' => 1],
        ],
    ],
]);
```