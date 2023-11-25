<?php
namespace App\Domain\Entity;

class Update {
    private $id;
    private $title;
    private $contents;
    private $userId;
    private $createdAt;

    public function __construct($id, $title, $contents, $userId, $createdAt) {
        $this->id = $id;
        $this->title = $title;
        $this->contents = $contents;
        $this->userId = $userId;
        $this->createdAt = $createdAt;
    }

    // ゲッターメソッド
    public function getId() {
        return $this->id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getContents() {
        return $this->contents;
    }

    public function getUserId() {
        return $this->userId;
    }

    public function getCreatedAt() {
        return $this->createdAt;
    }

    // セッターメソッドを追加
    public function setTitle(string $title): void {
        $this->title = $title;
    }

    public function setContents(string $contents): void {
        $this->contents = $contents;
    }
}
