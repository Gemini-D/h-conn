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

class Config
{
    /**
     * @var int
     */
    protected $packageMaxLength = 1024 * 1024 * 2;

    /**
     * @return int
     */
    public function getPackageMaxLength()
    {
        return $this->packageMaxLength;
    }

    /**
     * @param int $packageMaxLength
     * @return $this
     */
    public function setPackageMaxLength($packageMaxLength)
    {
        $this->packageMaxLength = $packageMaxLength;
        return $this;
    }
}
