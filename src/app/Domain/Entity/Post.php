<?php
namespace App\Domain\Entity;

class Post {
    private $title;
    private $contents;
    private $user_id;

    public function __construct($title, $contents, $user_id) {
        $this->title = $title;
        $this->contents = $contents;
        $this->user_id = $user_id;
    }

    // getter for title
    public function getTitle() {
        return $this->title;
    }

    // setter for title
    public function setTitle($title) {
        $this->title = $title;
    }

    // getter for contents
    public function getContents() {
        return $this->contents;
    }

    // setter for contents
    public function setContents($contents) {
        $this->contents = $contents;
    }

    // getter for user_id
    public function getUserId() {
        return $this->user_id;
    }

    // setter for user_id
    public function setUserId($user_id) {
        $this->user_id = $user_id;
    }
}

?>