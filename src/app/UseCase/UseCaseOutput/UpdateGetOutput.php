<?php
namespace App\UseCase\UseCaseOutput;

use App\Domain\Entity\Update;

final class UpdateGetOutput
{
    private $update;

    public function __construct(Update $update)
    {
        $this->update = $update;
    }

    public function getUpdate()
    {
        return $this->update;
    }
}
?>