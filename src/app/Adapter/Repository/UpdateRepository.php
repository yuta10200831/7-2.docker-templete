<?php
namespace App\Adapter\Repository;

use App\Domain\Entity\Update;
use App\Infrastructure\Dao\BLogDao;
use App\UseCase\UseCaseInput\UpdateInput;
use App\Domain\Port\IUpdateCommand;

final class UpdateRepository implements IUpdateCommand
{
    private BlogDao $blogDao;

    public function __construct() {
        $this->blogDao = new BlogDao();
    }

    public function update(UpdateInput $input): void {
        $blogIdValue = $input->getBlogId()->getValue();
        $titleValue = $input->getTitle()->getValue();
        $contentsValue = $input->getContents()->getValue();

        // データベース更新処理
        $this->blogDao->update($blogIdValue, $titleValue, $contentsValue);
    }
}

?>