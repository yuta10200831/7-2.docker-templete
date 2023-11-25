<?php
namespace App\UseCase\UseCaseOutput;

class UpdatePostOutput {
    public $result;

    public function __construct($result) {
        $this->result = $result;
    }
}
?>