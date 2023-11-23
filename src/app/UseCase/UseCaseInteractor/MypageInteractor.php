<?php
namespace App\UseCase\UseCaseInteractor;

use App\Adapter\QueryServise\MypageQueryService;
use App\UseCase\UseCaseInput\MypageInput;
use App\UseCase\UseCaseOutput\MypageOutput;
use App\Infrastructure\Dao\MypageDao;

final class MypageInteractor
{
    private $mypageQueryService;

    public function __construct() {
        $this->mypageDao = new MypageDao();
        $this->mypageQueryService = new MypageQueryService($this->mypageDao);
    }

    public function handle(MypageInput $input): MypageOutput {
        $blogs = $this->mypageQueryService->findByUserId($input->getUserId());
        return new MypageOutput($blogs);
    }
}
?>