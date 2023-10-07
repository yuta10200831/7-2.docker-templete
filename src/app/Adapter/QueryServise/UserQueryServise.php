<?php
namespace App\Adapter\QueryServise;
require_once __DIR__ . '/../../../vendor/autoload.php';

use App\Infrastructure\Dao\UserAgeDao;
use App\Infrastructure\Dao\UserDao;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\User\UserName;
use App\Domain\ValueObject\InputPassword;
use App\Domain\ValueObject\Age;
use App\Domain\Entity\User;
use App\Domain\ValueObject\HashedPassword;
use App\Domain\ValueObject\RegistrationDate;
use App\Domain\ValueObject\User\UserId;



final class UserQueryServise
{
    private $userDao;
    private $userAgeDao;

    public function __construct()
    {
        $this->userDao = new UserDao();
        $this->userAgeDao = new UserAgeDao();
    }

    public function findByEmail(Email $email): ?User
    {
        $userMapper = $this->userDao->findByEmail($email);
        if (is_null($userMapper)) {
            return null;
        }

        $userAgeMapper = $this->userAgeDao->fetchAll((int)$userMapper['id']);


        if (is_null($userAgeMapper) || !isset($userAgeMapper['age'])) {
            throw new \Exception('Age is null or not set');
        }

        $age = new Age((int)$userAgeMapper['age']);
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
?>