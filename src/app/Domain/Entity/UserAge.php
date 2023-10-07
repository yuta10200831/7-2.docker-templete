<?php

namespace App\Domain\Entity;
require_once __DIR__ . '/../../../vendor/autoload.php';
use App\Domain\ValueObject\User\UserId;
use App\Domain\ValueObject\User\Age;

/**
 * ユーザーのEntity
 */
final class UserAge
{
    /**
     * @var UserId
     */
    private $id;

    /**
     * @var Age
     */
    private $age;

    /**
     * コンストラクタ
     *
     * @param UserId $id
     * @param Age $age
     */
    public function __construct(UserId $id, Age $age)
    {
        echo "<!--";
        var_dump($age);
        echo "-->";
        $this->id = $id;
        $this->age = $age;
    }

    /**
     * @return UserId
     */
    public function id(): UserId
    {
        return $this->id;
    }

    /**
     * @return Age
     */
    public function age(): Age
    {
        return $this->age;
    }
}