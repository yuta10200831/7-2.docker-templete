<?php

namespace App\UseCase\UseCaseInteractor;

use App\UseCase\UseCaseInput\CreatePostInput;
use App\UseCase\UseCaseOutput\CreatePostOutput;
use App\Domain\Port\IPostCommand;
use App\Domain\Entity\Post;

final class CreatePostInteractor
{
    const COMPLETED_MESSAGE = "投稿が完了しました";

    private $postCommand;
    private $input;

    public function __construct(IPostCommand $postCommand, CreatePostInput $input)
    {
        $this->postCommand = $postCommand;
        $this->input = $input;
    }

    public function handle(): CreatePostOutput
    {
        $post = new Post(
            $this->input->getTitle(),
            $this->input->getContents(),
            $this->input->getUserId()
        );

        $this->postCommand->save($post);

        return new CreatePostOutput(true, self::COMPLETED_MESSAGE);
    }
}
?>