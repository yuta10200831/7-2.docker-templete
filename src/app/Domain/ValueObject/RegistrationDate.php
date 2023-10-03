<?php

namespace App\Domain\ValueObject;
use Exception;
use DateTime;

/**
 * 登録日用のValueObject
 */
final class RegistrationDate
{
    /**
     * 登録日が不正な場合のエラーメッセージ
     */
    const INVALID_MESSAGE = '登録日が不正です';

    /**
     * 日付の正規表現
     */
    const REGISTRATION_DATE_REGULAR_EXPRESSIONS = '/\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}/';

    /**
     * @var string
     */
    private $value;

    /**
     * コンストラクタ
     *
     * @param string $value
     */
    public function __construct(string $value)
    {
        if ($this->isInvalid($value)) {
            throw new Exception(self::INVALID_MESSAGE);
        }

        $this->value = $value;
    }

    /**
     * @return string
     */
    public function value(): string
    {
        return $this->value;
    }

    /**
     * 登録日のバリデーション
     *
     * @param string $value
     * @return boolean
     */
    private function isInvalid(string $value): bool
    {
        return !preg_match(self::REGISTRATION_DATE_REGULAR_EXPRESSIONS, $value);
    }

    /**
     * 長期顧客かを確認するメソッド
     *
     * @return boolean
     */
    public function isLongTermCustomer(): bool
    {
        date_default_timezone_set('Asia/Tokyo');
        $today = new DateTime('now');
        $registrationDateAndTime = new DateTime($this->value);
        $registrationDate = new DateTime(
            $registrationDateAndTime->format('Y-m-d')
        );

        $interval = $today->diff($registrationDate);
        $periodFromRegistration = $interval->format('%a');
        return $periodFromRegistration >= 30;
    }
}