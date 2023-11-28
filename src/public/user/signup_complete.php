<?php
session_start();

require_once __DIR__ . '/../../vendor/autoload.php';
use App\Infrastructure\Redirect\Redirect;
use App\Domain\ValueObject\User\UserName;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\Age;
use App\Domain\ValueObject\InputPassword;
use App\UseCase\UseCaseInput\SignUpInput;
use App\UseCase\UseCaseInteractor\SignUpInteractor;
use App\Infrastructure\Dao\UserDao;
use App\Infrastructure\Dao\UserAgeDao;
use App\Domain\Entity\UserAge;
use App\Domain\ValueObject\User\UserId;

$name = filter_input(INPUT_POST, 'name');
$email = filter_input(INPUT_POST, 'email');
$age = filter_input(INPUT_POST, 'age');
$password = filter_input(INPUT_POST, 'password');
$confirmPassword = filter_input(INPUT_POST, 'confirm_password');

if (empty($name)) {
    $_SESSION['errors'][] = 'ユーザー名を入力してください';
}
if (empty($email)) {
    $_SESSION['errors'][] = 'メールアドレスを入力してください';
}
if (empty($age)) {
    $_SESSION['errors'][] = '年齢を入力してください';
}

try {
    if (empty($password) || empty($confirmPassword)) {
        throw new Exception('パスワードを入力してください');
    }
    if ($password !== $confirmPassword) {
        throw new Exception('パスワードが一致しません');
    }

    $userName = new UserName($name);
    $userEmail = new Email($email);
    $userPassword = new InputPassword($password);
    $userAge = new Age($age);
    $useCaseInput = new SignUpInput(
        $userName,
        $userEmail,
        $userPassword,
        $userAge
    );
    $userDao = new UserDao();
    $userAgeDao = new UserAgeDao();
    $useCase = new SignUpInteractor($useCaseInput, $userDao, $userAgeDao);
    $useCaseOutput = $useCase->handler();

    if (!$useCaseOutput->isSuccess()) {
        throw new Exception($useCaseOutput->message());
    }
    $lastUserId = $userDao->getPdo()->lastInsertId();
    $userAgeObject = new UserAge(new UserId($lastUserId), new Age($age));
    $userAgeDao->create($userAgeObject);

    $_SESSION['message'] = $useCaseOutput->message();
    Redirect::handler('signin.php');
} catch (Exception $e) {
    $_SESSION['errors'][] = $e->getMessage();
    $_SESSION['user']['name'] = $name;
    $_SESSION['user']['email'] = $email;
    $_SESSION['user']['age'] = $age;
    Redirect::handler('signup.php');
}

?>