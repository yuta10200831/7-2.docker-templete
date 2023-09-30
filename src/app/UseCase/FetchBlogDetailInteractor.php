<?php
namespace App\UseCase\UseCaseInteractor;

use App\Adapter\Repository\BlogRepositoryInterface;

class FetchBlogDetailInteractor {
    private $blogRepository;

    public function __construct(BlogRepositoryInterface $blogRepository) {
        $this->blogRepository = $blogRepository;
    }

    public function getBlogById(int $id) {
        return $this->blogRepository->findById($id);
    }

    public function deleteBlogById(int $id) {
        $this->blogRepository->deleteById($id);
    }
}

?>