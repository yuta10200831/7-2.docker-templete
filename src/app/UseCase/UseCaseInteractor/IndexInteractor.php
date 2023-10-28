<?php
namespace App\UseCase\UseCaseInteractor;

use App\Adapter\Repository\BlogRepository;
use App\Adapter\QueryServise\BlogQueryService;
use App\UseCase\UseCaseInput\IndexInput;
use App\UseCase\UseCaseOutput\IndexOutput;

final class IndexInteractor
{
    private $blogRepository;
    private $blogQueryService;

    public function __construct(BlogRepository $blogRepository, BlogQueryService $blogQueryService)
    {
        $this->blogRepository = $blogRepository;
        $this->blogQueryService = $blogQueryService;
    }

    public function handle(IndexInput $input): IndexOutput
    {
        $blogs = $this->findAllBlogs($input->getSearchKeyword(), $input->getOrder());

        return new IndexOutput($blogs);
    }

    private function findAllBlogs(?string $searchKeyword, string $order): array
    {
        return $this->blogQueryService->findAllWithQuery($searchKeyword, $order);
    }
}

?>
å