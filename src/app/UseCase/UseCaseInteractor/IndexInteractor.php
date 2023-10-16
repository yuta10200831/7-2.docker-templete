<?php
namespace App\UseCase\UseCaseInteractor;

use App\Adapter\Repository\BlogRepository;
use App\Adapter\QueryService\BlogQueryService;
use App\UseCase\UseCaseInput\IndexInput;
use App\UseCase\UseCaseOutput\IndexOutput;

final class IndexInteractor {
    private $blogRepository;
    private $blogQueryService;

    public function __construct(BlogRepository $blogRepository, BlogQueryService $blogQueryService) {
        $this->blogRepository = $blogRepository;
        $this->blogQueryService = $blogQueryService;
    }

    public function handle(IndexInput $input): IndexOutput {
        $blogs = $this->blogQueryService->findAllWithQuery($input->getSearchKeyword(), $input->getOrder());
        return new IndexOutput($blogs);
    }
}
?>