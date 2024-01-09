<?php
require_once __DIR__ . '/../../../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use App\Domain\ValueObject\Post\Title;

final class TitleTest extends TestCase
{
    /**
     * @test
     */
    public function タイトルが30文字以内の場合_例外が発生しないこと(): void
    {
        $validTitle = str_repeat('a', 30); // 30文字の文字列
        $title = new Title($validTitle);

        $this->assertSame($validTitle, $title->getValue());
    }

    /**
     * @test
     */
    public function タイトルが31文字以上の場合_例外が発生すること(): void
    {
        $this->expectException(\Exception::class);

        new Title(str_repeat('a', 31)); // 31文字の文字列
    }
}

?>