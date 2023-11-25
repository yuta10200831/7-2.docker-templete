<?php
namespace App\UseCase\UseCaseInteractor;

use App\UseCase\UseCaseInput\UpdateInput;
use App\UseCase\UseCaseOutput\UpdateOutput;
use App\Adapter\Repository\BlogRepositoryInterface;
use App\Domain\Entity\Update;

class UpdateInteractor {
    private $updateRepository;
    private $input;

    public function __construct(UpdateInput $input) {
        // 後ほど修正する
        $this->blogRepository = new BlogRepositoryInterface();
        $this->input = $input;
    }

    public function handle(): UpdatePostOutput {

        $blog = new Blog($this->input->getBlogId(), $this->input->getTitle(), $this->input->getContents(), $this->input->getUserId(), '');
        $result = $this->blogRepo->update($blog);

        return new UpdatePostOutput($result);
    }
}
?>
