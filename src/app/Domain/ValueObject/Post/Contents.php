<?php
namespace App\Domain\ValueObject\Post;
use Exception;

class Contents
{
    private string $value;

    public function __construct(string $value) {
        if (mb_strlen($value) > 3000) {
            throw new \Exception("内容は3000文字以内にしてください");
        }
        $this->value = $value;
    }

    public function getValue(): string {
        return $this->value;
    }
}
?>
