<?php
namespace app\models;
use Yii;
use yii\base\Model;

/**
 *
 */
class ClassName extends Model
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
            ['password', 'string', 'min' => 6, 'max' => 255],
            ['repeatPassword', 'string', 'min' => 6, 'max' => 255],
            ['password','compare','compareAttribute'=>'repeatPassword'],
            ['email', 'email'],
        ];
    }

    public function signup()
    {
        # code...
    }
}


?>
