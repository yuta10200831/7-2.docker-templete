<?php
require_once __DIR__ . '/../../vendor/autoload.php';
use App\Infrastructure\Redirect\Redirect;
use App\Domain\ValueObject\User\UserName;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\InputPassword;
use App\UseCase\UseCaseInput\SignUpInput;
use App\UseCase\UseCaseInteractor\SignUpInteractor;

$name = filter_input(INPUT_POST, 'name');
$email = filter_input(INPUT_POST, 'email');
$password = filter_input(INPUT_POST, 'password');
$confirmPassword = filter_input(INPUT_POST, 'confirm_password');


try {
    session_start();
    // var_dump($name);
    // var_dump($email);
    // var_dump($password);
    // var_dump($confirmPassword);
    if (empty($password) || empty($confirmPassword)) {
        throw new Exception('パスワードを入力してください');
    }
    if ($password !== $confirmPassword) {
        throw new Exception('パスワードが一致しません');
    }

    $userName = new UserName($name);
    $userEmail = new Email($email);
    $userPassword = new InputPassword($password);
    $useCaseInput = new SignUpInput($userName, $userEmail, $userPassword);
    $useCase = new SignUpInteractor($useCaseInput);
    $useCaseOutput = $useCase->handler();

    var_dump($name, $email, $password, $confirmPassword);

    if (!$useCaseOutput->isSuccess()) {
        throw new Exception($useCaseOutput->message());
    }
    $_SESSION['message'] = $useCaseOutput->message();
    Redirect::handler('./signin.php');
} catch (Exception $e) {
    $_SESSION['errors'][] = $e->getMessage();
    $_SESSION['user']['name'] = $name;
    $_SESSION['user']['email'] = $email;
    Redirect::handler('./signup.php');
}
