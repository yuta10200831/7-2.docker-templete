<?php

namespace App\Adapter\Repository;
require_once __DIR__ . '/../../../vendor/autoload.php';
use App\Infrastructure\Dao\UserDao;
use App\Infrastructure\Dao\UserAgeDao;
use App\Domain\ValueObject\User\NewUser;
use App\Domain\Entity\UserAge;

final class UserRepository
{
    /**
     * @var UserDao
     */
    private $userDao;
    private $userAge;

    public function __construct()
    {
        $this->userDao = new UserDao();
        $this->userAgeDao = new UserAgeDao();
    }

    public function insert(NewUser $user): void
    {
        $this->userDao->create($user);
    }

    public function getLastInsertId(): int
    {
        return $this->userDao->lastInsertId();
    }

    public function insertAge(UserAge $userAge): void
    {
        $this->userAgeDao->create($userAge);
    }
}
?>