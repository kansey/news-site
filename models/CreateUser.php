<?php
namespace app\models;
use Yii;
use yii\base\Model;
use app\models\User;

/**
 *
 */
class CreateUser extends Model
{
    public $login;
    public $password;
    public $email;
    public $status;

    public function rules()
    {
        return [
            //[['login','password','email','status'],'required'],
            //[['login','password','email','status'],'trim'],
            ['login', 'unique',  'targetClass' => '\models\User', 'message' => 'This username has already been taken.'],
            ['login', 'string', 'min' => 2, 'max' => 255],
            ['password', 'string', 'min' => 6, 'max' => 255],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => '\app\models\User', 'message' => 'This email address has already been taken.'],
            ['status', 'in', 'range' => ['moder', 'admin'], 'strict'=>false],
        ];
    }


}
