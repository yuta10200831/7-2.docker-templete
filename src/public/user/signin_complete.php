<?php
require_once __DIR__ . '/../../vendor/autoload.php';
use App\Infrastructure\Redirect\Redirect;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\InputPassword;
use App\UseCase\UseCaseInput\SignInInput;
use App\Infrastructure\Dao\UserAgeDao;
use App\UseCase\UseCaseInteractor\SignInInteractor;
use App\Domain\Port\IUserQuery;
use App\Adapter\QueryServise\UserQueryServise;

session_start();
$email = filter_input(INPUT_POST, 'email');
$password = filter_input(INPUT_POST, 'password');
try {
    if (empty($email) || empty($password)) {
        throw new Exception('パスワードとメールアドレスを入力してください');
    }

    $userEmail = new Email($email);
    $inputPassword = new InputPassword($password);
    $useCaseInput = new SignInInput($userEmail, $inputPassword);
    $queryService = new UserQueryServise();
    $useCase = new SignInInteractor($useCaseInput, $queryService);
    $userAgeDao = new UserAgeDao();
    $useCaseOutput = $useCase->handler();

    if (!$useCaseOutput->isSuccess()) {
        throw new Exception($useCaseOutput->message());
    }
    Redirect::handler('../index.php');
} catch (Exception $e) {
    $_SESSION['errors'][] = $e->getMessage();
    Redirect::handler('./signin.php');
}
