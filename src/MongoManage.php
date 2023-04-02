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

use MongoDB\Driver\BulkWrite;
use MongoDB\Driver\Command;
use MongoDB\Driver\Exception\Exception;
use MongoDB\Driver\Manager;
use MongoDB\Driver\Query;

class MongoManage
{
    protected Manager $manage;

    protected string $database;

    public function __construct(protected array $config)
    {
        $uri = 'mongodb://';
        if (! empty($this->config['username']) && ! empty($this->config['password'])) {
            $uri .= $this->config['username'] . ':' . $this->config['password'] . '@';
        }
        $uri .= $this->config['host'] . ':' . $this->config['port'];
        $this->database = $this->config['database'];
        $this->manage = new Manager($uri);
    }

    public function insert(string $table, array $document): ?int
    {
        $bulk = new BulkWrite();
        $bulk->insert($document);
        return $this->manage->executeBulkWrite($this->getNamespace($table), $bulk)->getInsertedCount();
    }

    public function batchInsert(string $table, array $data): ?int
    {
        $bulk = new BulkWrite();
        foreach ($data as $document) {
            $bulk->insert($document);
        }
        return $this->manage->executeBulkWrite($this->getNamespace($table), $bulk)->getInsertedCount();
    }

    public function update(string $table, array $filter, array $updateData, array $options = []): ?int
    {
        $bulk = new BulkWrite();
        $bulk->update(
            $filter,
            ['$set' => $updateData],
            $options
        );

        return $this->manage->executeBulkWrite($this->getNamespace($table), $bulk)->getMatchedCount();
    }

    public function delete(string $table, array $filter, array $options = ['limit' => 1]): ?int
    {
        $bulk = new BulkWrite();
        $bulk->delete($filter, $options);

        return $this->manage->executeBulkWrite($this->getNamespace($table), $bulk)->getDeletedCount();
    }

    /**
     * @throws Exception
     */
    public function query(string $table, array $filter, array $options = []): array
    {
        $query = new Query($filter, $options);
        return $this->manage->executeQuery($this->getNamespace($table), $query)->toArray();
    }

    /**
     * @throws Exception
     */
    public function cmd(array $cmd): array
    {
        $command = new Command($cmd);
        return $this->manage->executeCommand($this->database, $command)->toArray();
    }

    protected function getNamespace(string $table): string
    {
        return $this->database . '.' . $table;
    }
}
