<?php
namespace App\Domain\ValueObject;

use Exception;

class BlogId
{
    private int $value;

    public function __construct(int $value)
    {
        if ($value <= 0) {
            throw new Exception("ブログIDは正の整数である必要があります");
        }
        $this->value = $value;
    }

    public function getValue(): int
    {
        return $this->value;
    }
}
