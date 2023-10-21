<?php
namespace App\UseCase\UseCaseInput;

final class IndexInput
{
    private $search_keyword;
    private $order;

    public function __construct(?string $searchKeyword, string $order, int $userId)
    {
        $this->searchKeyword = $searchKeyword;
        $this->order = $order;
        $this->userId = $userId;
    }

    public function getSearchKeyword(): ?string {
        return $this->searchKeyword;
    }

    public function getOrder(): string {
        return $this->order;
    }

    public function getUserId(): int {
        return $this->userId;
    }
}
?>