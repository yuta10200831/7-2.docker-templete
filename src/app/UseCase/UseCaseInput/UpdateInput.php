<?php
namespace App\UseCase\UseCaseInput;

use App\Domain\ValueObject\Index\BlogId;
use App\Domain\ValueObject\Post\Title;
use App\Domain\ValueObject\Post\Contents;

final class UpdateInput
{
    private $blogId;
    private $title;
    private $contents;

    public function __construct(BlogId $blogId, Title $title, Contents $contents)
    {
        $this->blogId = $blogId;
        $this->title = $title;
        $this->contents = $contents;
    }

    public function getBlogId(): BlogId
    {
        return $this->blogId;
    }

    public function getTitle(): Title
    {
        return $this->title;
    }

    public function getContents(): Contents
    {
        return $this->contents;
    }
}

?>