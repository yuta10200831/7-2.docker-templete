<?php
namespace App\UseCase\UseCaseInteractor;

use App\UseCase\UseCaseInput\MyArticleDetailInput;
use App\UseCase\UseCaseOutput\MyArticleDetailOutput;
use App\Adapter\QueryServise\MyArticleDetailQueryService;
use App\Domain\Port\IMyArticleDetailQuery;

final class MyArticleDetailInteractor
{
    private $myArticleDetailQueryService;
    private $input;

    public function __construct(MyArticleDetailInput $input, IMyArticleDetailQuery $queryService)
    {
        $this->input = $input;
        $this->myArticleDetailQueryService = $queryService;
    }

    public function handle(): MyArticleDetailOutput
    {
        $blogId = $this->input->getBlogId();
        $article = $this->myArticleDetailQueryService->findById($blogId);

        return new MyArticleDetailOutput($article);
    }
}
?>