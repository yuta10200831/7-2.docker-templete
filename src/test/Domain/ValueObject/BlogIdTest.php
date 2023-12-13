<?php
require_once __DIR__ . '/../../../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use App\Domain\ValueObject\Index\BlogId;

final class BlogIdTest extends TestCase
{
    /**
     * @test
     */
    public function 正の整数の場合_例外が発生しないこと(): void
    {
        $expected = 10;
        $blogId = new BlogId($expected);

        $this->assertSame($expected, $blogId->getValue());
    }

    /**
     * @test
     */
    public function ゼロ以下の場合_例外が発生すること(): void
    {
        $this->expectException(\Exception::class);

        new BlogId(0);
    }

    /**
     * @test
     */
    public function 負の整数の場合_例外が発生すること(): void
    {
        $this->expectException(\Exception::class);

        new BlogId(-1);
    }
}
?>