<?php
namespace Domain;

interface UserRepository {
    public function findByEmail($email);
    public function save(User $user);
}
