<?php
namespace App\Domain\Port;

use App\Domain\Entity\User;
use App\Domain\ValueObject\User\NewUser;
use App\Domain\Entity\UserAge;

interface IUserCommand
{
    public function insert(NewUser $newUser): void;
    public function getLastInsertId(): int;
    public function insertAge(UserAge $userAge): void;
}
?>