<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
namespace HConn\Server;

use HConn\Config;
use HConn\Packer;
use HConn\Packet;
use Swoole\Coroutine;
use Swoole\Coroutine\Server;
use Swoole\Coroutine\Server\Connection;

class SwooleServer
{
    /**
     * @var Server
     */
    protected $server;

    /**
     * @var callable
     */
    protected $handler;

    /**
     * @var Packer
     */
    protected $packer;

    /**
     * @var Config
     */
    protected $config;

    public function __construct(Config $config)
    {
        $this->packer = new Packer();
        $this->config = $config;
    }

    /**
     * @return $this
     */
    public function bind(string $name, int $port)
    {
        if ($this->server) {
            throw new \RuntimeException('The server bind again.');
        }
        $this->server = new Server($name, $port);
        $this->server->set([
            'open_length_check' => true,
            'package_max_length' => $this->config->getPackageMaxLength(),
            'package_length_type' => 'N',
            'package_length_offset' => 0,
            'package_body_offset' => 4,
        ]);
        return $this;
    }

    /**
     * @return $this
     */
    public function handle(callable $callable)
    {
        $this->handler = $callable;
        return $this;
    }

    public function start(): void
    {
        $this->server->handle(function (Connection $conn) {
            while (true) {
                $ret = $conn->recv();
                if (empty($ret)) {
                    break;
                }

                Coroutine::create(function () use ($ret, $conn) {
                    $packet = $this->packer->unpack($ret);
                    $id = $packet->getId();
                    $result = $this->handler->__invoke($packet);
                    $conn->send($this->packer->pack(new Packet($id, (string) $result)));
                });
            }
        });

        $this->server->start();
    }
}
