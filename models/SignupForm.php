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
        $user->email    = $this->email;
        $user->status   = User::STATUS_GUEST;
        $user->setPassword($this->password);
        $user->genereateToken();
        $user->generateAuthKey();

        return $user->save() ? $user : null;
    }

    public function sendMessageAdmins($email)
    {
        $admins = User::find()
            ->asArray()
            ->select(['email'])
            ->where(['status' => 'admin'])
            ->all();

        foreach ($admins as $admin) {
            $sendEmail = Yii::$app->mailer->compose()
                ->setFrom([\Yii::$app->params['adminEmail'] => 'Register a new user from' . \Yii::$app->name])
                ->setTo($admin['email'])
                ->setSubject('Register a new user from')
                ->setTextBody("New user from ". $email)
                ->send();
        }
        return empty($admins) ? false : true;
    }
}
?>
