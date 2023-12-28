<?php

namespace App\UseCase\UseCaseInteractor;

use App\UseCase\UseCaseInput\UpdateInput;
use App\UseCase\UseCaseOutput\UpdateOutput;
use App\Adapter\Repository\UpdateRepository;
use App\Adapter\QueryServise\UpdateQueryService;
use App\Domain\Entity\Update;
use App\Domain\Port\IUpdateCommand;
use App\Domain\Port\IUpdateQuery;

final class UpdateInteractor
{
    const COMPLETED_MESSAGE = "編集が完了しました";

    private $updateRepository;
    private $updateQueryService;
    private $input;

    public function __construct(UpdateInput $input, IUpdateQuery $updateQueryService, IUpdateCommand $updateCommand)
    {
        $this->updateQueryService = $updateQueryService;
        $this->updateCommand= $updateCommand;
        $this->input = $input;
    }

    public function handle(): UpdateOutput
    {
        $blogId = $this->input->getBlogId();
        $existingUpdate = $this->updateQueryService->findById($blogId);

        if (!$existingUpdate) {
            throw new \Exception("指定された記事が見つかりません。");
        }

        $this->updateRepository->update($this->input);

        return new UpdateOutput(true, self::COMPLETED_MESSAGE);
    }
}
?>