<?php
namespace App\Adapter\Repository;

use App\Domain\Entity\Update;
use App\Infrastructure\Dao\UpdateDao;

final class UpdateRepository
{
    private $dao;

    public function __construct() {
        $this->dao = new UpdateDao();
    }

    public function update(Update $blog): void {
        $titleValue = $blog->getTitle()->getValue();
        $contentsValue = $blog->getContents()->getValue();

        $this->dao->update($blog->getId(), $titleValue, $contentsValue);
    }
}
?>