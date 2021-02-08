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
use HConn\Packer;
use HConn\Packet;
use Swoole\Coroutine\Socket;
use function Swoole\Coroutine\run;

require_once __DIR__ . '/../vendor/autoload.php';

run(function () {
    $socket = new Socket(AF_INET, SOCK_STREAM, 0);
    $retval = $socket->connect('127.0.0.1', 9601);
    $packer = new Packer();

    while ($retval) {
        $body = 'Hello World.';
        // $body = str_repeat('aa', 1024);
        $n = $socket->send($packer->pack(new Packet(1, $body)));
        var_dump($n);

        $data = $socket->recv();
        var_dump($data);

        if (empty($data)) {//发生错误或对端关闭连接，本端也需要关闭
            $socket->close();
            break;
        }
        usleep(10 * 1000);
    }
});
