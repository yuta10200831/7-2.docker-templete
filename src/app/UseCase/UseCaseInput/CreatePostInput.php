<?php

namespace App\UseCase\UseCaseInput;
require_once __DIR__ . '/../../../vendor/autoload.php';
use App\Domain\ValueObject\Post\Title;
use App\Domain\ValueObject\Post\Contents;

final class CreatePostInput
{
    private $title;
    private $contents;
    private $user_id;

    public function __construct(Title $title, Contents $contents, string $user_id)
    {
        $this->title = $title;
        $this->contents = $contents;
        $this->user_id = $user_id;
    }

    public function getTitle(): Title {
        return $this->title;
    }

    public function getContents(): Contents {
        return $this->contents;
    }

    public function getUserId(): string {
        return $this->user_id;
    }
}
?>