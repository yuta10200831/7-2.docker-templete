<?php
namespace App\UseCase\UseCaseInteractor;

use App\Adapter\Repository\BlogRepository;
use App\Adapter\QueryServise\BlogQueryService;
use App\UseCase\UseCaseInput\IndexInput;
use App\UseCase\UseCaseOutput\IndexOutput;
use App\Infrastructure\Dao\BlogDao;

final class IndexInteractor
{
    private $blogDao;
    private $blogQueryService;
    private $input;

    public function __construct(IndexInput $input) {
        $this->blogDao = new BlogDao();
        $this->blogQueryService = new BlogQueryService($this->blogDao);
        $this->input = $input;
    }

    public function handle(): IndexOutput {
        $blogs = $this->findAllBlogs($this->input->getSearchKeyword(), $this->input->getOrder());
        return new IndexOutput($blogs);
    }

    private function findAllBlogs(?string $searchKeyword, string $order): array {
        return $this->blogQueryService->findAllWithQuery($searchKeyword, $order);
    }
}

?>