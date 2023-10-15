<?php

namespace App\UseCase\UseCaseInteractor;
require_once __DIR__ . '/../../../vendor/autoload.php';
use App\UseCase\UseCaseInput\CreatePostInput;
use App\UseCase\UseCaseOutput\CreatePostOutput;
use App\Adapter\Repository\PostRepository;
use App\Infrastructure\Dao\PostDao;
use App\Domain\Entity\Post;
use App\Domain\ValueObject\Post\Title;
use App\Domain\ValueObject\Post\Contents;

class CreatePostInteractor
{
    private $postRepository;
    private $input;

    public function __construct(CreatePostInput $input)
    {
        $createDao = new PostDao();

        $this->postRepository = new PostRepository($createDao);
        $this->input = $input;
    }

    public function handle(): CreatePostOutput
    {
        $post = new Post(
            $this->input->getTitle(),
            $this->input->getContents(),
            $this->input->getUserId()
        );

        $newId = $this->postRepository->save($post);

        return new CreatePostOutput($newId);
    }
}


?>
