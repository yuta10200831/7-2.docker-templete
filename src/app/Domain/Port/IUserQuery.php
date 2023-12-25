<?php
namespace App\Domain\Port;

use App\Domain\ValueObject\Email;
use App\Domain\Entity\User;

interface IUserQuery {
    public function findByEmail(Email $email): ?User;
}

interface IUserAgeDao {
    public function fetchAll(int $userId): ?array;
}
?>