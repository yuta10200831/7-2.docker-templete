<?php
namespace App\UseCase\UseCaseInput;

class UpdatePostInputData {
    public $blog_id;
    public $title;
    public $contents;
    public $user_id;

    public function __construct($blog_id, $title, $contents, $user_id) {
        $this->blog_id = $blog_id;
        $this->title = $title;
        $this->contents = $contents;
        $this->user_id = $user_id;
    }
}
