<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use App\UseCase\UseCaseInteractor\SignInInteractor;
use App\UseCase\UseCaseInput\SignInInput;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\InputPassword;
use App\Domain\Port\IUserQuery;
use App\Domain\Entity\User;
use App\Domain\ValueObject\User\UserId;
use App\Domain\ValueObject\User\UserName;
use App\Domain\ValueObject\HashedPassword;
use App\Domain\ValueObject\Age;
use App\Domain\ValueObject\RegistrationDate;

final class SignInTest extends TestCase
{
    /**
     * @test
     */
    public function ユーザーが見つかる場合のログインテスト()
    {
        $email = new Email('test@example.com');
        $password = new InputPassword('Password123');
        $input = new SignInInput($email, $password);

        $userQueryInterface = new class implements IUserQuery {
          public function findByEmail(Email $email): ?User {
              if ($email->value() === 'test@example.com') {
                  return new User(
                      new UserId(1),
                      new UserName('Test User'),
                      $email,
                      new HashedPassword(password_hash('Password123', PASSWORD_DEFAULT)),
                      new Age(25),
                      new RegistrationDate((new \DateTimeImmutable('now'))->format('Y-m-d H:i:s'))
                  );
              }
              return null;
          }
      };
        $interactor = new SignInInteractor($input, $userQueryInterface);
        $output = $interactor->handler();

        $this->assertTrue($output->isSuccess());
    }

    /**
     * @test
     */
    public function ユーザーが見つからない場合のログインテスト()
    {
        $email = new Email('notfound@example.com');
        $password = new InputPassword('Password123');
        $input = new SignInInput($email, $password);

        $userQueryInterface = new class implements IUserQuery {
            public function findByEmail(Email $email): ?User {
                return null;
            }
        };

        $interactor = new SignInInteractor($input, $userQueryInterface);
        $output = $interactor->handler();

        $this->assertFalse($output->isSuccess());
    }
}
?>