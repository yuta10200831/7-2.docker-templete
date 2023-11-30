<?php
namespace App\UseCase\UseCaseInteractor;

use App\UseCase\UseCaseInput\UpdatePostInputData;
use App\UseCase\UseCaseOutput\UpdatePostOutputData;
use App\Infrastructure\Dao\BlogRepositoryMySQLImpl;
use App\Domain\Entity\Blog;

class UpdatePostInteractor {
    private $blogRepo;

    public function __construct(BlogRepositoryMySQLImpl $blogRepo) {
        $this->blogRepo = $blogRepo;
    }

    public function handle(UpdatePostInputData $inputData): UpdatePostOutputData {
        $blog = new Blog((int)$inputData->blog_id, $inputData->title, $inputData->contents, $inputData->user_id, '');
        $result = $this->blogRepo->update($blog);

        return new UpdatePostOutputData($result);
    }
}
