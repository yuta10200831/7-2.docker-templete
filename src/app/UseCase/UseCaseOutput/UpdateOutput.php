<?php
namespace App\UseCase\UseCaseOutput;

final class UpdateOutput
{
    private $blogs;
    private $isSuccess;

    public function __construct($blogs, $isSuccess = true)
    {
        $this->blogs = $blogs;
        $this->isSuccess = $isSuccess;
    }

    public function getBlogs()
    {
        return $this->blogs;
    }

    public function isSuccess(): bool
    {
        return $this->isSuccess;
    }
}

?>