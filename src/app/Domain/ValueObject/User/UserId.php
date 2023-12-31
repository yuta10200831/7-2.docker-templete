<?php

namespace App\Domain\ValueObject\User;
use Exception;

/**
 * ユーザーIDのValueObject
 */
final class UserId
{
    // 下記は後ほど削除、=0が正
    const MIN_VALUE = 1;
    // const MIN_VALUE = 0;
    const INVALID_MESSAGE = '不正な値です';

    /**
     * @var int
     */
    private $value;

    /**
     * コンストラクタ
     *
     * @param int $value
     */
    public function __construct(int $value)
    {
        if ($this->isInvalid($value))
        {
            throw new Exception(self::INVALID_MESSAGE);
        }
        $this->value = $value;
    }

    /**
     * @return int
     */
    public function value(): int
    {
        return $this->value;
    }

    /**
     * 0以上かどうかを判定する
     *
     * @param string $value
     * @return boolean
     */
    private function isInvalid(int $value): bool
    {
        return $value < self::MIN_VALUE;
    }
}
?>