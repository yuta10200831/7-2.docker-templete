<?php
require_once __DIR__ . '/../../../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use App\Domain\ValueObject\InputPassword;
use App\Domain\ValueObject\HashedPassword;

final class InputPasswordTest extends TestCase
{
    /**
     * @test
     */
    public function 有効パスワードの場合_例外が発生しないこと(): void
    {
        $validPassword = 'ValidPass123';
        $inputPassword = new InputPassword($validPassword);

        $this->assertSame($validPassword, $inputPassword->value());
    }

    /**
     * @test
     */
    public function 無効パスワードの場合_例外が発生すること(): void
    {
        $this->expectException(\Exception::class);

        new InputPassword('invalid');
    }

    /**
     * @test
     */
    public function パスワードをハッシュ化する(): void
    {
        $inputPassword = new InputPassword('ValidPass123');
        $hashedPassword = $inputPassword->hash();

        $this->assertInstanceOf(HashedPassword::class, $hashedPassword);
        $this->assertTrue(password_verify('ValidPass123', $hashedPassword->value()));
    }
}
?>