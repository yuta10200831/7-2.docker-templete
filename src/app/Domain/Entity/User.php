<?php

namespace App\Domain\Entity;
require_once __DIR__ . '/../../../vendor/autoload.php';
use App\Domain\ValueObject\User\UserId;
use App\Domain\ValueObject\User\UserName;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\HashedPassword;
use App\Domain\ValueObject\Age;
use App\Domain\ValueObject\RegistrationDate;

/**
 * ユーザーのEntity
 */
final class User
{
    /**
     * @var UserId
     */
    private $id;

    /**
     * @var UserName
     */
    private $name;

    /**
     * @var Email
     */
    private $email;

    /**
     * @var HashedPassword
     */
    private $password;

    /**
     * @var Age
     */
    private $age;

    /**
     * @var RegistrationDate
     */
    private $registrationDate;

    /**
     * コンストラクタ
     *
     * @param UserId $id
     * @param UserName $name
     * @param Email $email
     * @param HashedPassword $password
     * @param Age $age
     * @param RegistrationDate $registrationDate
     */
    public function __construct(
        UserId $id,
        UserName $name,
        Email $email,
        HashedPassword $password,
        Age $age,
        RegistrationDate $registrationDate
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->age = $age;
        $this->registrationDate = $registrationDate;
    }

    /**
     * @return UserId
     */
    public function id(): UserId
    {
        return $this->id;
    }

    /**
     * @return UserName
     */
    public function name(): UserName
    {
        return $this->name;
    }

    /**
     * @return Email
     */
    public function email(): Email
    {
        return $this->email;
    }

    /**
     * @return HashedPassword
     */
    public function password(): HashedPassword
    {
        return $this->password;
    }

    /**
     * @return Age
     */
    public function age(): Age
    {
        return $this->age;
    }

    /**
     * @return RegistrationDate
     */
    public function registrationDate(): RegistrationDate
    {
        return $this->registrationDate;
    }

    /**
     * @return bool
     */
    public function isPremiumMember(): bool
    {
        return $this->registrationDate->isLongTermCustomer() &&
            $this->age->isAdult();
    }
}