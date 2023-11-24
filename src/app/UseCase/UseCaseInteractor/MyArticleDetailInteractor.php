<?php
namespace App\UseCase\UseCaseInteractor;

use App\UseCase\UseCaseInput\MyArticleDetailInput;
use App\UseCase\UseCaseOutput\MyArticleDetailOutput;
use App\Adapter\QueryServise\MyArticleDetailQueryService;

final class MyArticleDetailInteractor
{
    private $myArticleDetailQueryService;
    private $input;

    public function __construct(MyArticleDetailInput $input)
    {
        $this->input = $input;
        $this->myArticleDetailQueryService = new MyArticleDetailQueryService();
    }

    public function handle(): MyArticleDetailOutput
    {
        $blogId = $this->input->getBlogId();
        $article = $this->myArticleDetailQueryService->findById($blogId);

        return new MyArticleDetailOutput($article);
    }
}

?>
