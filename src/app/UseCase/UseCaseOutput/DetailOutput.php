<?php
namespace App\UseCase\UseCaseOutput;

final class DetailOutput
{
    private $blogs;

    public function __construct($blogs)
    {
        $this->blogs = $blogs;
    }

    public function getBlogs()
    {
        return $this->blogs;
    }
}
?>