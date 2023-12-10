<?php
require_once __DIR__ . '/../../../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use App\Domain\ValueObject\HashedPassword;
use App\Domain\ValueObject\InputPassword;

final class HashedPasswordTest extends TestCase
{
    private $rawPassword = 'Password123';
    private $hashedPassword;

    protected function setUp(): void
    {
        // ハッシュ化されたパスワードをセットアップ
        $this->hashedPassword = password_hash($this->rawPassword, PASSWORD_DEFAULT);
    }

    /**
     * @test
     */
    public function 有効なパスワードの場合_例外が発生しないこと(): void
    {
        $hashedPasswordObj = new HashedPassword($this->hashedPassword);

        $this->assertSame($this->hashedPassword, $hashedPasswordObj->value());
    }

    /**
     * @test
     */
    public function 照合が成功する場合_trueを返すこと(): void
    {
        $hashedPasswordObj = new HashedPassword($this->hashedPassword);
        $inputPasswordObj = new InputPassword($this->rawPassword);

        $this->assertTrue($hashedPasswordObj->verify($inputPasswordObj));
    }

    /**
     * @test
     */
    public function 照合が失敗する場合_falseを返すこと(): void
    {
        $hashedPasswordObj = new HashedPassword($this->hashedPassword);
        $inputPasswordObj = new InputPassword('ValidPass1234');

        $this->assertFalse($hashedPasswordObj->verify($inputPasswordObj));
    }
}
?>