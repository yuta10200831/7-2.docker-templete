<?php
namespace App\Domain\Entity;
use App\Domain\ValueObject\Index\BlogId;

class Comment {
    private $id;
    private $comment;
    private $blogId;
    private $commenterName;
    private $createdAt;

    public function __construct($id, $comment, BlogId $blogId, $commenterName, $createdAt) {
        $this->id = $id;
        $this->comment = $comment;
        $this->blogId = $blogId;
        $this->commenterName = $commenterName;
        $this->createdAt = $createdAt;
    }

    public function getId() {
        return $this->id;
    }

    public function getComment() {
        return $this->comment;
    }

    public function getBlogId() {
        return $this->blogId;
    }

    public function getCommenterName() {
        return $this->commenterName;
    }

    public function getCreatedAt() {
        return $this->createdAt;
    }
}
?>