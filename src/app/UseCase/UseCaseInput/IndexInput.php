<?php
namespace App\UseCase\UseCaseInput;

final class IndexInput
{
    private $search_keyword;
    private $order;

    public function __construct($search_keyword, $order)
    {
        $this->search_keyword = $search_keyword;
        $this->order = $order;
    }

    public function getSearchKeyword()
    {
        return $this->search_keyword;
    }

    public function getOrder()
    {
        return $this->order;
    }
}
?>