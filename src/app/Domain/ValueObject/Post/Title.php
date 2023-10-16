<?php
namespace App\Domain\ValueObject;

class Title {
    private $value;

    public function __construct($value) {
        if (empty($value)) {
            throw new \Exception("タイトルを入力して下さい");
        }
        $this->value = $value;
    }

    public function getValue() {
        return $this->value;
    }
}
?>