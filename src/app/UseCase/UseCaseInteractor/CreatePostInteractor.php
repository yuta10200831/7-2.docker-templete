<?php

namespace App\UseCase\UseCaseInteractor;
require_once __DIR__ . '/../../../vendor/autoload.php';
use App\UseCase\UseCaseInput\CreatePostInput;
use App\UseCase\UseCaseOutput\CreatePostOutput;
use App\Adapter\Repository\PostRepository;
use App\Domain\Entity\Post;

final class CreatePostInteractor
{
    const COMPLETED_MESSAGE = "投稿が完了しました";

    private $postRepository;
    private $input;

    public function __construct(CreatePostInput $input)
    {
        $this->postRepository = new PostRepository();
        $this->input = $input;
    }

    public function handle(): CreatePostOutput
    {
        $post = new Post(
            $this->input->getTitle(),
            $this->input->getContents(),
            $this->input->getUserId()
        );

        $this->postRepository->save($post);

        return new CreatePostOutput(true, self::COMPLETED_MESSAGE);
    }
}
?>