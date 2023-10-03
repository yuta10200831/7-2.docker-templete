<?php

namespace App\Domain\ValueObject;
use Exception;

/**
 * 年齢用のValueObject
 */
final class Age
{
    /**
     * 年齢が不正な場合のエラーメッセージ
     */
    const INVALID_MESSAGE = '正しい年齢をご記入ください！';

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
        if ($this->isInvalid($value)) {
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
     * 年齢のバリデーション
     *
     * @param int $value
     * @return boolean
     */
    private function isInvalid(int $value): bool
    {
        return $value < 0 || 150 < $value;
    }

    /**
     * 成年かを確認するメソッド
     *
     * @return boolean
     */
    public function isAdult(): bool
    {
        return $this->value >= 18;
    }
}