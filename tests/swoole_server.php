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

use HConn\Config;
use HConn\Server\SwooleServer;
use function Swoole\Coroutine\run;
use HConn\Packet;

require_once __DIR__ . '/../vendor/autoload.php';

run(function () {
    $server = new SwooleServer(new Config());
    $server->bind('0.0.0.0', 9601)->handle(static function (Packet $packet) {
        return 'Hello ' . $packet->getBody();
    })->start();
});
