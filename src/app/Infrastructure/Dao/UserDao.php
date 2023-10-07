<?php

namespace App\Infrastructure\Dao;
use App\Domain\ValueObject\User\NewUser;
use \PDO;
use \Exception;

final class UserDao
{

    const TABLE_NAME = 'users';

    private $pdo;

    public function __construct()
    {
        try {
            $this->pdo = new PDO(
                'mysql:dbname=blog;host=mysql;charset=utf8',
                'root',
                'password'
            );
        } catch (\PDOException $e) {
            throw new Exception('DB接続エラー: ' . $e->getMessage());
        }
    }

    public function getPdo()
    {
        return $this->pdo;
    }

    public function findByEmail($email): ?array
    {
        $sql = sprintf(
            'SELECT * FROM %s WHERE email = :email',
            self::TABLE_NAME
        );
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':email', $email->value(), PDO::PARAM_STR);

        if (!$statement->execute()) {
            throw new Exception('SQL実行エラー');
        }

        $user = $statement->fetch(PDO::FETCH_ASSOC);
        return $user === false ? null : $user;
    }

    public function lastInsertId()
    {
        return $this->pdo->lastInsertId();
    }

    public function create(NewUser $user): void
    {
        $hashedPassword = $user->password()->hash();

        $sql = sprintf(
            'INSERT INTO %s (name, email, password) VALUES (:name, :email, :password)',
            self::TABLE_NAME
        );

        $statement = $this->pdo->prepare($sql);

        $statement->bindValue(':name', $user->name()->value(), PDO::PARAM_STR);
        $statement->bindValue(':email', $user->email()->value(), PDO::PARAM_STR);
        $statement->bindValue(':password', $hashedPassword->value(), PDO::PARAM_STR);

        if (!$statement->execute()) {
            throw new Exception('User could not be created.');
        }
    }
}


?>