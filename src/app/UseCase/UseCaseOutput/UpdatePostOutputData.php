<?php
namespace App\UseCase\UseCaseOutput;

class UpdatePostOutputData {
    public $result;

    public function __construct($result) {
        $this->result = $result;
    }
}
?>