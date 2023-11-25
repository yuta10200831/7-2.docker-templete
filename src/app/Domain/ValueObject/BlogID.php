<?php
namespace App\Domain\ValueObject;

class BlogId {
    private $blogId;

    public function __construct($blogId) {
        if (empty($blogId)) {
            throw new \InvalidArgumentException('BlogIDが入力されていません');
        }
        $this->blogId = $blogId;
    }

    public function getValue() {
        return $this->blogId;
    }
}

?>