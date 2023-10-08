<?php
namespace App\UseCase\UseCaseInput;
require_once __DIR__ . '/../../../vendor/autoload.php';

use App\Domain\ValueObject\Title;
use App\Domain\ValueObject\Contents;

class CreatePostInputData {
    public $title;
    public $contents;
    public $user_id;

    public function __construct(Title $title, Contents $contents, $user_id) {
        $this->title = $title;
        $this->contents = $contents;
        $this->user_id = $user_id;
    }
}
