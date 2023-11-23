<?php
namespace App\UseCase\UseCaseOutput;

final class CommentOutput
{
    private $isSuccess;
    private $message;
    private $comments;

    public function __construct(bool $isSuccess, string $message, array $comments = [])
    {
        $this->isSuccess = $isSuccess;
        $this->message = $message;
        $this->comments = $comments;
    }

    public function isSuccess(): bool
    {
        return $this->isSuccess;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getComments(): array
    {
        return $this->comments;
    }
}
?>