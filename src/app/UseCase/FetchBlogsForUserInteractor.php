<?php
namespace App\UseCase\UseCaseInteractor;

use App\Adapter\Repository\BlogRepositoryInterface;

class FetchBlogsForUserInteractor {
    private $blogRepository;

    public function __construct(BlogRepositoryInterface $blogRepository) {
        $this->blogRepository = $blogRepository;
    }

    public function handle($userId): array {
        return $this->blogRepository->findByUserId($userId);
    }
}
