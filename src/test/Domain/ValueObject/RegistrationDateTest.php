<?php
require_once __DIR__ . '/../../../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use App\Domain\ValueObject\RegistrationDate;

final class RegistrationDateTest extends TestCase
{
    /**
     * @test
     */
    public function 有効な登録日の場合_例外が発生しないこと(): void
    {
        $validDate = '2020-01-01 12:00:00';
        $registrationDate = new RegistrationDate($validDate);

        $this->assertSame($validDate, $registrationDate->value());
    }

    /**
     * @test
     */
    public function 無効な登録日の場合_例外が発生すること(): void
    {
        $this->expectException(\Exception::class);

        new RegistrationDate('invalid-date');
    }

    /**
     * @test
     */
    public function 長期顧客の場合_trueを返すこと(): void
    {
        $oldDate = '2020-01-01 12:00:00';
        $registrationDate = new RegistrationDate($oldDate);

        $this->assertTrue($registrationDate->isLongTermCustomer());
    }

    /**
     * @test
     */
    public function 新規顧客の場合_falseを返すこと(): void
    {
      $recentDate = (new DateTime('now'))->format('Y-m-d H:i:s');
      $registrationDate = new RegistrationDate($recentDate);

        $this->assertFalse($registrationDate->isLongTermCustomer());
    }
}
?>