<?php
namespace App\UseCase\UseCaseInteractor;

use App\UseCase\UseCaseInput\CreatePostInputData;
use Application\UseCase\OutputData\CreatePostOutputData;
use App\Adapter\Repository\PostRepositoryInterface;
use App\Domain\Entity\Post;

class CreatePostInteractor {
    private $postRepository;

    public function __construct(PostRepositoryInterface $postRepository) {
        $this->postRepository = $postRepository;
    }

    public function handle(CreatePostInputData $inputData) {
        $post = new Post(
            $inputData->title,
            $inputData->contents,
            $inputData->user_id
        );
        $this->postRepository->save($post);
    }
}
?>
