<?php
namespace App\UseCase\UseCaseInput;

class CreatePostInputData {
    public $title;
    public $contents;
    public $user_id;

    public function __construct($title, $contents, $user_id) {
        $this->title = $title;
        $this->contents = $contents;
        $this->user_id = $user_id;
    }
}
