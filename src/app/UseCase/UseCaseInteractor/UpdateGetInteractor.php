<?php
namespace App\UseCase\UseCaseInteractor;

use App\UseCase\UseCaseInput\UpdateGetInput;
use App\Adapter\QueryServise\UpdateQueryService;
use App\UseCase\UseCaseOutput\UpdateGetOutput;
use App\Domain\Port\IUpdateQuery;

class UpdateGetInteractor
{
    private $updateQueryService;
    private $input;

    public function __construct(UpdateGetInput $input, IUpdateQuery $updateQueryService)
    {
        $this->input = $input;
        $this->updateQueryService = $updateQueryService;
    }

    public function handle(): UpdateGetOutput
    {
        $blogId = $this->input->getBlogId();
        $update = $this->updateQueryService->findById($blogId);

        return new UpdateGetOutput($update);
    }
}

?>