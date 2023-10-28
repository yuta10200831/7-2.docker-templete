<?php
namespace App\Domain\ValueObject;

use Exception;

class CommentText
{
    private string $value;

    public function __construct(string $value) {
        if (empty(trim($value))) {
            throw new Exception("コメントを入力して下さい");
        }
        $this->value = $value;
    }

    public function getValue(): string {
        return $this->value;
    }
}
?>
