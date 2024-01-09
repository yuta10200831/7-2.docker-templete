<?php
require_once __DIR__ . '/../../../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use App\Domain\ValueObject\Post\Contents;

final class ContentsTest extends TestCase
{
    /**
     * @test
     */
    public function 内容が3000文字以内の場合_例外が発生しないこと(): void
    {
        $validContent = str_repeat('a', 3000); // 3000文字の文字列
        $contents = new Contents($validContent);

        $this->assertSame($validContent, $contents->getValue());
    }

    /**
     * @test
     */
    public function 内容が3001文字以上の場合_例外が発生すること(): void
    {
        $this->expectException(\Exception::class);

        new Contents(str_repeat('a', 3001)); // 3001文字の文字列
    }
}

?>