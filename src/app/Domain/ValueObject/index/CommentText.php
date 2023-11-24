<?php
namespace App\Domain\ValueObject\Index;

use Exception;

class CommentText {
    private string $value;
    private const MAX_LENGTH = 30;

    public function __construct(string $value) {
        if (mb_strlen($value) > self::MAX_LENGTH) {
            throw new Exception("コメントは最大 " . self::MAX_LENGTH . " 文字までです。");
        }

        $this->value = $value;
    }

    public function getValue(): string {
        return $this->value;
    }
}
?>