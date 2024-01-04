<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use App\UseCase\UseCaseInteractor\SignUpInteractor;
use App\UseCase\UseCaseInput\SignUpInput;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\User\UserName;
use App\Domain\ValueObject\InputPassword;
use App\Domain\ValueObject\Age;
use App\Domain\Port\IUserCommand;
use App\Domain\Port\IUserQuery;
use App\Domain\Entity\User;
use App\Domain\ValueObject\User\UserId;
use App\Domain\ValueObject\User\NewUser;
use App\Domain\Entity\UserAge;
use App\Domain\ValueObject\HashedPassword;
use App\Domain\ValueObject\RegistrationDate;

final class SignUpTest extends TestCase
{
    /**
     * @test
     */
    public function 新規ユーザーの正常な登録()
    {
        $email = new Email('newuser@example.com');
        $name = new UserName('NewUser');
        $password = new InputPassword('Password123');
        $age = new Age(25);
        $input = new SignUpInput($name, $email, $password, $age);

        $userQueryInterface = new class implements IUserQuery {
            public function findByEmail(Email $email): ?User {
                return null;
            }
        };
        $userCommandInterface = new class implements IUserCommand {
            public function insert(NewUser $newUser): void {}
            public function getLastInsertId(): int { return 123; }
            public function insertAge(UserAge $userAge): void {}
        };

        $interactor = new SignUpInteractor($input, $userQueryInterface, $userCommandInterface);
        $output = $interactor->handler();

        $this->assertTrue($output->isSuccess());
        $this->assertEquals('登録が完了しました', $output->message());
    }

    /**
     * @test
     */
    public function 既存のメールアドレスでの登録試行()
    {
        $email = new Email('existing@example.com');
        $name = new UserName('Existing User');
        $password = new InputPassword('Password123');
        $age = new Age(25);
        $input = new SignUpInput($name, $email, $password, $age);

        $userQueryInterface = new class implements IUserQuery {
            public function findByEmail(Email $email): ?User {
                $hashedPassword = new HashedPassword('hashed_password_dummy');
                $registrationDate = new RegistrationDate('2023-01-01 00:00:00');
                return new User(
                    new UserId(1),
                    new UserName('Existing User'),
                    $email,
                    $hashedPassword,
                    new Age(25),
                    $registrationDate
                );
            }
        };

        $userCommandInterface = new class implements IUserCommand {
            public function insert(NewUser $newUser): void {}
            public function getLastInsertId(): int { return 123; }
            public function insertAge(UserAge $userAge): void {}
        };

        $interactor = new SignUpInteractor($input, $userQueryInterface, $userCommandInterface);
        $output = $interactor->handler();

        $this->assertFalse($output->isSuccess());
        $this->assertEquals('すでに登録済みのメールアドレスです', $output->message());
    }
}
?>