<?php
namespace App\Domain\Port;

interface IBlogQuery {
    public function findAllWithQuery(?string $searchKeyword, string $order): array;
}
?>