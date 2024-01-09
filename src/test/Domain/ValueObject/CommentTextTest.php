<?php
require_once __DIR__ . '/../../../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use App\Domain\ValueObject\Index\CommentText;

final class CommentTextTest extends TestCase
{
    /**
     * @test
     */
    public function コメントが30文字以内の場合_例外が発生しないこと(): void
    {
        $validText = str_repeat('a', 30); // 30文字の文字列
        $commentText = new CommentText($validText);

        $this->assertSame($validText, $commentText->getValue());
    }

    /**
     * @test
     */
    public function コメントが31文字以上の場合_例外が発生すること(): void
    {
        $this->expectException(\Exception::class);

        new CommentText(str_repeat('a', 31)); // 31文字の文字列
    }
}

?>