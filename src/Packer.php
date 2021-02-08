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
namespace HConn;

class Packer
{
    public function pack(Packet $packet): string
    {
        return pack('N', strlen($packet->getBody()) + 4) .
            pack('N', $packet->getId()) .
            $packet->getBody();
    }

    public function unpack(string $data): Packet
    {
        $id = unpack('N', substr($data, 4, 4));
        $body = substr($data, 8);
        return new Packet((int) $id, $body);
    }
}
