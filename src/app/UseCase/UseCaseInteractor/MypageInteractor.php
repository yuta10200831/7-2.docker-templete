<?php
namespace App\UseCase\UseCaseInteractor;

use App\Adapter\QueryServise\MypageQueryService;
use App\UseCase\UseCaseInput\MypageInput;
use App\UseCase\UseCaseOutput\MypageOutput;
use App\Infrastructure\Dao\MypageDao;
use App\Domain\Port\IMypageQuery;

final class MypageInteractor
{
    private $mypageQueryService;
    private $input;

    public function __construct(MypageInput $input,IMypageQuery $queryService) {
        $this->input = $input;
        $this->mypageDao = new MypageDao();
        $this->mypageQueryService = $queryService;
    }

    public function handle(): MypageOutput {
        $userId = $this->input->getUserId();
        $blogs = $this->mypageQueryService->findByUserId($userId);
        return new MypageOutput($blogs);
    }
}
?>