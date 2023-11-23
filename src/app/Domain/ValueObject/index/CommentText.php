<?php
namespace App\Domain\ValueObject\Index;

use Exception;

class CommentText {
    private string $value;

    public function __construct(string $value) {

        $this->value = $value;
    }

    public function getValue(): string {
        return $this->value;
    }
}

?>
