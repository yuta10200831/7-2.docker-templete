<?php
require_once __DIR__ . '/../../../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use App\Domain\ValueObject\Age;

final class AgeTest extends TestCase
{
    /**
     * @test
     */
    public function 有効年齢の場合_例外が発生しないこと(): void
    {
        $age = new Age(25);

        $this->assertSame(25, $age->value());
    }

    /**
     * @test
     */
    public function 年齢が負の数の場合_例外が発生すること(): void
    {
        $this->expectException(\Exception::class);

        new Age(-1);
    }

    /**
     * @test
     */
    public function 年齢が150を超える場合_例外が発生すること(): void
    {
        $this->expectException(\Exception::class);

        new Age(151);
    }

    /**
     * @test
     */
    public function 成年の場合_trueを返すこと(): void
    {
        $age = new Age(18);

        $this->assertTrue($age->isAdult());
    }

    /**
     * @test
     */
    public function 未成年の場合_falseを返すこと(): void
    {
        $age = new Age(17);

        $this->assertFalse($age->isAdult());
    }
}
?>