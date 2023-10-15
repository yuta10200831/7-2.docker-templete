<?php

namespace App\UseCase\UseCaseOutput;

final class CreatePostOutput
{
    private $post_id;

    public function __construct(int $post_id)
    {
        $this->post_id = $post_id;
    }

    public function postId(): int
    {
        return $this->post_id;
    }
}

?>