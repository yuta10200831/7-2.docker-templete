<?php
namespace App\Domain\Port;

use App\Domain\ValueObject\User\UserId;
use App\Domain\Entity\Mypage;

interface IMypageQuery {
    public function findByUserId(UserId $userId): array;
}
