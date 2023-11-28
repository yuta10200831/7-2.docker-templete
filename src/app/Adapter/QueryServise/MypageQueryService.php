<?php
namespace App\Adapter\QueryServise;
require_once __DIR__ . '/../../../vendor/autoload.php';
use App\Infrastructure\Dao\MypageDao;
use App\Domain\Entity\Mypage;
use App\Domain\ValueObject\User\UserId;
use App\Domain\ValueObject\Post\Contents;
use App\Domain\ValueObject\Post\Title;

final class MypageQueryService
{
    private $mypageDao;

    public function __construct() {
        $this->mypageDao = new MypageDao();
    }

public function findByUserId($userId): array {
    $mypageMappers = $this->mypageDao->findByUserId($userId);

    $mypages = [];
    foreach ($mypageMappers as $mypageMapper) {
        $title = new Title($mypageMapper['title']);
        $contents = new Contents($mypageMapper['contents']);
        $userId = new UserId($mypageMapper['user_id']);

        $mypages[] = new Mypage(
            $mypageMapper['id'],
            $title,
            $contents,  
            $userId,
            $mypageMapper['created_at']
        );
    }

    return $mypages;
}

public function findById($id): ?Mypage {
    $mypageMapper = $this->mypageDao->findById($id);
    if ($mypageMapper === null) {
        return null;
    }

    $title = new Title($mypageMapper['title']);
    $contents = new Contents($mypageMapper['contents']);
    $userId = new UserId($mypageMapper['user_id']);

    return new Mypage(
        $mypageMapper['id'],
        $title,
        $contents,
        $userId,
        $mypageMapper['created_at']
    );
}

}
?>