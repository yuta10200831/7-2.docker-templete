<?php
namespace App\UseCase\UseCaseOutput;

final class MypageOutput
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