<?php

namespace App\Adapter\QueryServise;
require_once __DIR__ . '/../../../vendor/autoload.php';
use App\Infrastructure\Dao\UserDao;
use App\Domain\Entity\User;
use App\Domain\ValueObject\User\UserId;
use App\Domain\ValueObject\User\UserName;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\HashedPassword;
use App\Domain\ValueObject\Age;
use App\Domain\ValueObject\RegistrationDate;


final class UserQueryServise
{
    /**
     * @var UserDao
     */
    private $userDao;

    public function __construct()
    {
        $this->userDao = new UserDao();
    }

    public function findByEmail(Email $email): ?User
    {
        $userMapper = $this->userDao->findByEmail($email);

        if ($this->notExistsUser($userMapper)) {
            return null;
        }

        $ageValue = isset($userMapper['age']) ? (int)$userMapper['age'] : null;

        if ($ageValue === null) {
            // nullのときの処理（例外を投げる、ログを出すなど）
            throw new \Exception('Age is null');
        }

        $age = new Age($ageValue);
        $registrationDate = new RegistrationDate($userMapper['registration_date']);

        return new User(
            new UserId($userMapper['id']),
            new UserName($userMapper['name']),
            new Email($userMapper['email']),
            new HashedPassword($userMapper['password']),
            $age,
            $registrationDate
        );
    }

    private function notExistsUser(?array $user): bool
    {
        return is_null($user);
    }
}
