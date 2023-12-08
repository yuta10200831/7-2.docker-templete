<?php
require_once __DIR__ . '/../../../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use App\Domain\ValueObject\Email;

final class EmailTest extends TestCase
{
    /**
     * @test
     */
    public function 有効メールアドレスの場合_例外が発生しないこと(): void
    {
        $validEmail = 'test@example.com';
        $email = new Email($validEmail);

        $this->assertSame($validEmail, $email->value());
    }

    /**
     * @test
     */
    public function 無効メールアドレスの場合_例外が発生すること(): void
    {
        $this->expectException(\Exception::class);

        new Email('invalid-email');
    }

    /**
     * @test
     */
    public function 空メールアドレスの場合_例外が発生すること(): void
    {
        $this->expectException(\Exception::class);

        new Email('');
    }

    /**
     * @test
     */
    public function 不正フォーマットのメールアドレスの場合_例外が発生すること(): void
    {
        $this->expectException(\Exception::class);

        new Email('test@.com');
    }
}
?>