<?php
namespace App\UseCase\UseCaseInteractor;

use App\UseCase\UseCaseInput\DetailInput;
use App\UseCase\UseCaseOutput\DetailOutput;
use App\Adapter\QueryServise\DetailQueryService;

final class DetailInteractor
{

    private $detailQueryService;
    private $input;

    public function __construct(DetailInput $input)
    {
        $this->input = $input;
        $this->detailQueryService = new DetailQueryService();
    }

    public function handle(): DetailOutput
    {
        $blogId = $this->input->getBlogId();
        $detail = $this->detailQueryService->findById($blogId);

        return new DetailOutput($detail);
    }
}

?>
