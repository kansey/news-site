<?php
namespace app\models;
use Yii;
use yii\base\Model;
use app\models\User;

/**
 *
 */
class SignupForm extends Model
{
    public $login;
    public $password;
    public $repeatPassword;
    public $email;

    public function rules()
    {
        return [
            [['login','password','repeatPassword','email'],'required'],
            [['login','password','repeatPassword','email'],'trim'],
            ['login', 'string', 'min' => 2, 'max' => 255],
            ['login', 'unique', 'targetClass' => '\app\models\User', 'message' => 'This username has already been taken.'],
            ['password', 'string', 'min' => 6, 'max' => 255],
            ['repeatPassword', 'string', 'min' => 6, 'max' => 255],
            ['repeatPassword','compare','compareAttribute'=>'password'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => '\app\models\User', 'message' => 'This email address has already been taken.'],
        ];
    }

    public function signup()
    {

        if (!$this->validate()) {
          return null;
        }

        $user           = new User();
        $user->login    = $this->login;
        $user->password = $user->setPassword($this->password);
        $user->email    = $this->email;
        return $user->save() ? $user : null;
    }
}


?>
