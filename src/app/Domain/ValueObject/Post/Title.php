<?php
namespace App\Domain\ValueObject\Post;
use Exception;

class Title
{
    private string $value;

    public function __construct(string $value) {
        if (mb_strlen($value) > 30) {
            throw new \Exception("タイトルは30文字以内にしてください");
        }
        $this->value = $value;
    }

    public function getValue(): string {
        return $this->value;
    }
}
?>