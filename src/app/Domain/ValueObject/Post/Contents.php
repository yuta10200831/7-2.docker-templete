<?php
namespace App\Domain\ValueObject\Post;
use Exception;

class Contents
{
    private $value;

    public function __construct($value) {
        if (empty($value)) {
            throw new \Exception("内容を入力してください");
        }
        $this->value = $value;
    }
    public function getValue() {
        return $this->value;
    }
}
?>