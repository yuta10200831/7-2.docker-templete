<?php
namespace App\UseCase\UseCaseInteractor;

use App\UseCase\UseCaseInput\UpdatePostInputData;
use App\UseCase\UseCaseOutput\UpdatePostOutputData;
use App\Adapter\Repository\BlogRepositoryInterface;
use App\Domain\Entity\Blog;

class UpdatePostInteractor {
    private $blogRepo;

    public function __construct(BlogRepositoryInterface $blogRepo) {
        $this->blogRepo = $blogRepo;
    }

    public function handle(UpdatePostInputData $inputData): UpdatePostOutputData {

        $blog = new Blog($inputData->blog_id->getValue(), $inputData->title, $inputData->contents, $inputData->user_id, '');
        $result = $this->blogRepo->update($blog);

        return new UpdatePostOutputData($result);

    }
}
?>
