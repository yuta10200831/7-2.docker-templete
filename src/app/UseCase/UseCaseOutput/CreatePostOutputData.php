<?php
namespace App\UseCase\UseCaseOutput;

class CreatePostOutputData {
    public $post_id;

    public function __construct($post_id) {
        $this->post_id = $post_id;
    }
}

?>