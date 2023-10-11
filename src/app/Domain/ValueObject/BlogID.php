<?php
namespace App\Domain\ValueObject;

class BlogID {
    private $blogID;

    public function __construct($blogID) {
        if (empty($blogID)) {
            throw new \InvalidArgumentException('BlogIDが入力されていません');
        }
        $this->blogID = $blogID;
    }

    public function getValue() {
        return $this->blogID;
    }
}

?>