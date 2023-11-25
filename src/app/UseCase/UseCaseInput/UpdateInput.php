<?php
namespace App\UseCase\UseCaseInput;
require_once __DIR__ . '/../../../vendor/autoload.php';

use App\Domain\ValueObject\Title;
use App\Domain\ValueObject\Contents;

class UpdateInput
{
    private $title;
    private $contents;
    private $blog_id;
    private $user_id;

    public function __construct(string $blog_id, Title $title, Contents $contents, string $user_id) {
        $this->blog_id = $blog_id;
        $this->title = $title;
        $this->contents = $contents;
        $this->user_id = $user_id;
    }

    public function getTitle(): Title {
        return $this->getValue()->title;
    }

    public function getContents(): Contents {
        return $this->contents;
    }

    public function getUserId(): string {
        return $this->user_id;
    }

    public function getBlogId(): string {
        return $this->blog_id;
    }
}
?>