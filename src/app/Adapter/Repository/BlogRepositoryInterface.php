<?php
namespace App\Adapter\Repository;

use App\Domain\Entity\Blog;

interface BlogRepositoryInterface {
    public function findByUserId($userId): array;
    public function findById(int $id): ?Blog;
    public function deleteById(int $id): bool;
}
