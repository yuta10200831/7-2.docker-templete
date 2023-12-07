<?php

namespace App\UseCase\UseCaseInteractor;

use App\UseCase\UseCaseInput\UpdateInput;
use App\UseCase\UseCaseOutput\UpdateOutput;
use App\Adapter\Repository\UpdateRepository;
use App\Adapter\QueryServise\UpdateQueryService;
use App\Domain\Entity\Update;

final class UpdateInteractor
{
    const COMPLETED_MESSAGE = "編集が完了しました";

    private $updateRepository;
    private $updateQueryService;
    private $input;

    public function __construct(UpdateInput $input)
    {
        $this->updateRepository = new UpdateRepository();
        $this->updateQueryService = new UpdateQueryService();
        $this->input = $input;
    }

    public function handle(): UpdateOutput
    {
        $blogId = $this->input->getBlogId();
        $existingUpdate = $this->updateQueryService->findById($blogId);

        if (!$existingUpdate) {
            throw new \Exception("指定された記事が見つかりません。");
        }

        // 記事内容の更新
        $existingUpdate->setTitle($this->input->getTitle());
        $existingUpdate->setContents($this->input->getContents());

        // 更新処理
        $this->updateRepository->update($existingUpdate);

        return new UpdateOutput(true, self::COMPLETED_MESSAGE);
    }
}

// namespace App\UseCase\UseCaseInteractor;

// use App\UseCase\UseCaseInput\UpdateInput;
// use App\UseCase\UseCaseOutput\UpdateOutput;
// use App\Adapter\Repository\UpdateRepository;
// use App\Adapter\QueryServise\UpdateQueryService;
// use App\Domain\Entity\Update;
// use App\Domain\ValueObject\Index\BlogId;
// use App\Domain\ValueObject\Post\Title;
// use App\Domain\ValueObject\Post\Contents;

// final class UpdateInteractor
// {
//     const COMPLETED_MESSAGE = "編集が完了しました";

//     private $updateRepository;
//     private $updateQueryService;
//     private $input;

//     public function __construct(UpdateInput $input)
//     {
//         $this->updateRepository = new UpdateRepository();
//         $this->updateQueryService = new UpdateQueryService();
//         $this->input = $input;
//     }

//     public function handle(): UpdateOutput
//     {
//         $blogIdValue = $this->input->getBlogId()->getValue();
//         $blogId = new BlogId($blogIdValue);

//         // 既存の記事を取得
//         $existingUpdate = $this->updateQueryService->findById($blogId);

//         if (!$existingUpdate) {
//             throw new \Exception("指定された記事が見つかりません。");
//         }

//         // 記事内容の更新
//         $existingUpdate->setTitle($this->input->getTitle());
//         $existingUpdate->setContents($this->input->getContents());

//         // 更新処理
//         $this->updateRepository->update($existingUpdate);

//         return new UpdateOutput(true, self::COMPLETED_MESSAGE);
//     }
// }

?>