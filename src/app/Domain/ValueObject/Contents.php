<?php
namespace App\Domain\ValueObject;

class Contents {
    private $contents;

    public function __construct($contents) {
        if (empty($contents)) {
            throw new \InvalidArgumentException('Contentsが空です');
        }
        $this->contents = $contents;
    }

    public function getValue() {
        return $this->contents;
    }
}

?>