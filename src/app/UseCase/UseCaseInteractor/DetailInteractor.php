<?php
namespace App\UseCase\UseCaseInteractor;

use App\UseCase\UseCaseInput\DetailInput;
use App\UseCase\UseCaseOutput\DetailOutput;
use App\Adapter\QueryServise\DetailQueryService;

final class DetailInteractor
{
    private $detailQueryService;

    public function __construct()
    {
        $this->detailQueryService = new DetailQueryService();
    }

    public function handle(DetailInput $input): DetailOutput
    {
        $blogId = $input->getBlogId();
        $detail = $this->detailQueryService->findById($blogId);

        return new DetailOutput($detail);
    }
}

?>
