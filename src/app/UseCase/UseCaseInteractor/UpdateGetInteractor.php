<?php
namespace App\UseCase\UseCaseInteractor;

use App\UseCase\UseCaseInput\UpdateGetInput;
use App\Adapter\QueryServise\UpdateQueryService;
use App\UseCase\UseCaseOutput\UpdateGetOutput;

class UpdateGetInteractor
{
    private $updateQueryService;
    private $input;

    public function __construct(UpdateGetInput $input)
    {
        $this->input = $input;
        $this->updateQueryService = new UpdateQueryService();
    }

    public function handle(): UpdateGetOutput
    {
        $blogId = $this->input->getBlogId();
        $update = $this->updateQueryService->findById($blogId);

        return new UpdateGetOutput($update);
    }
}

?>