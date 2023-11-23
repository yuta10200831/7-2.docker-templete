<?php
namespace App\UseCase\UseCaseInteractor;

use App\UseCase\UseCaseInput\MyArticleDetailInput;
use App\UseCase\UseCaseOutput\MyArticleDetailOutput;
use App\Adapter\QueryServise\MyArticleDetailQueryService;

final class MyArticleDetailInteractor
{
    private $myArticleDetailQueryService;

    public function __construct()
    {
        $this->myArticleDetailQueryService = new MyArticleDetailQueryService();
    }

    public function handle(MyArticleDetailInput $input): MyArticleDetailOutput
    {
        $blogId = $input->getBlogId();
        $article = $this->myArticleDetailQueryService->findById($blogId);

        return new MyArticleDetailOutput($article);
    }
}

?>
