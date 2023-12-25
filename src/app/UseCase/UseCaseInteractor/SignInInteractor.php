<?php

namespace App\UseCase\UseCaseInteractor;
require_once __DIR__ . '/../../../vendor/autoload.php';
use App\Adapter\QueryServise\UserQueryServise;
use App\Infrastructure\Dao\UserAgeDao;
use App\UseCase\UseCaseInput\SignInInput;
use App\UseCase\UseCaseOutput\SignInOutput;
use App\Domain\Entity\User;
use App\Domain\ValueObject\User\UserId;
use App\Domain\ValueObject\User\UserName;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\Age;
use App\Domain\ValueObject\RegistrationDate;
use App\Domain\ValueObject\HashedPassword;
use App\Domain\Port\IUserQuery;

/**
 * ログインユースケース
 */
final class SignInInteractor
{
    /**
     * ログイン失敗時のエラーメッセージ
     */
    const FAILED_MESSAGE = 'メールアドレスまたは<br />パスワードが間違っています';

    /**
     * ログイン成功時のメッセージ
     */
    const SUCCESS_MESSAGE = 'ログインしました';

    /**
     * @var UserQueryServise
     */
    private $userQueryServise;

    /**
     * @var SignInInput
     */
    private $input;

    /**
     * コンストラクタ
     *
     * @param SignInInput $input
     */
    public function __construct(SignInInput $input, IUserQuery $queryService)
    {
        $this->userQueryServise = $queryService;
        $this->userAgeDao = new UserAgeDao();
        $this->input = $input;
    }

    /**
     * ログイン処理
     * セッションへのユーザー情報の保存も行う
     *
     * @return SignInOutput
     */
    public function handler(): SignInOutput
    {
        $user = $this->findUser();

        if ($this->notExistsUser($user)) {
            return new SignInOutput(false, self::FAILED_MESSAGE);
        }

        $userMapper = $this->createUserEntity($user);
        if ($userMapper === null) {
            throw new \Exception('年齢の登録をしてください!');
        }

        if ($this->isInvalidPassword($user->password())) {
            return new SignInOutput(false, self::FAILED_MESSAGE);
        }

        $this->saveSession($user);

        return new SignInOutput(true, self::SUCCESS_MESSAGE);
    }

    /**
     * ユーザーを入力されたメールアドレスで検索する
     *
     * @return array | null
     */
    private function findUser(): ?User
    {
        return $this->userQueryServise->findByEmail($this->input->email());
    }

    /**
     * ユーザーが存在しない場合
     *
     * @param array|null $user
     * @return boolean
     */
    private function notExistsUser(?User $user): bool
    {
        return is_null($user);
    }

    /**
     * パスワードが正しいかどうか
     *
     * @param HashedPassword $hashedPassword
     * @return boolean
     */
    private function isInvalidPassword(HashedPassword $hashedPassword): bool
    {
        return !$hashedPassword->verify($this->input->password());
    }

    /* UserEntityを作成する
    *
    * @param array $user
    * @return ?User
    */
    private function createUserEntity(User $user): ?User
    {
        $userId = $user->id()->value();
        $userAge = $this->userAgeDao->fetchAll($userId);

        if ($userAge === null) {
            return null;
        }

        return new User(
            $user->id(),
            $user->name(),
            $user->email(),
            $user->password(),
            new Age($userAge['age']),
            $user->registrationDate()
        );
    }

    /**
     * セッションの保存処理
     *
     * @param User $user
     * @return void
     */
    private function saveSession(User $user): void
    {
        $_SESSION['user']['id'] = $user->id()->value();
        $_SESSION['user']['name'] = $user->name()->value();
        if ($user->isPremiumMember()) {
            $_SESSION['user']['memberStatus'] = 'プレミアム会員';
        }

        if (!$user->isPremiumMember()) {
            $_SESSION['user']['memberStatus'] = 'ノーマル会員';
        }
    }
}
