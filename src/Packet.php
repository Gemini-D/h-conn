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

class Packet
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $body;

    public function __construct(int $id, string $body)
    {
        $this->id = $id;
        $this->body = $body;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getBody(): string
    {
        return $this->body;
    }
}
