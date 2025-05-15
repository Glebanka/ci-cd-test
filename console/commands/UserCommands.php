<?

namespace app\commands;

use common\models\User;
use yii\console\Controller;
use yii\console\ExitCode;

class UserCommands extends Controller
{

    public function actionAdd()
    {
        $username = $this->prompt('Введите имя пользователя:', ['required' => true]);
        $email = $this->prompt('Введите email:', [
            'required' => true,
            'validator' => function ($input, &$error) {
                if (!filter_var($input, FILTER_VALIDATE_EMAIL)) {
                    $error = 'Некорректный email.';
                    return false;
                }
                return true;
            },
        ]);
        $password = $this->prompt('Введите пароль:', ['required' => true]);
        $user = new User();
        $user->username = $username;
        $user->email = $email;
        $user->setPassword($password);
        $user->status = 10;
        $user->generateAuthKey();
        if(User::find()->where(["email" => $user->email])->exists()){
            echo "Пользователь с таким email уже существует.\n";
            return ExitCode::OK;
        }
        if(User::find()->where(["username" => $user->username])->exists()){
            echo "Пользователь с таким именем уже существует.\n";
            return ExitCode::OK;
        }
        if ($user->save()) {
            echo "Пользователь успешно добавлен.\n";
            return ExitCode::OK;
        } else {
            echo "Ошибка при добавлении пользователя:\n";
            print_r($user->errors);
            return ExitCode::UNSPECIFIED_ERROR;
        }
    }
}
