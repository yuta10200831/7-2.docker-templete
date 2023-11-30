<?php
namespace App\Domain\Entity;

use App\Domain\ValueObject\User\UserId;
use App\Domain\ValueObject\Post\Contents;
use App\Domain\ValueObject\Post\Title;

final class Mypage {
    private $id;
    private $title;
    private $contents;
    private $userId;
    private $createdAt;

    public function __construct(int $id, Title $title, Contents $contents, UserId $userId, string $createdAt) {
        $this->id = $id;
        $this->title = $title;
        $this->contents = $contents;
        $this->userId = $userId;
        $this->createdAt = $createdAt;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getTitle(): Title {
        return $this->title;
    }

    public function getContents(): Contents {
        return $this->contents;
    }

    public function getUserId(): UserId {
        return $this->userId;
    }

    public function getCreatedAt(): string {
        return $this->createdAt;
    }

    public function setTitle(Title $title): void {
        $this->title = $title;
    }

    public function setContents(Contents $contents): void {
        $this->contents = $contents;
    }
}
?>
