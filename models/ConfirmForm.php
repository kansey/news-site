<?php
namespace app\models;
use Yii;
use yii\base\Model;
use app\models\User;

/**
 *
 */
class ConfirmForm extends Model
{
    public $password;
    public $repeatPassword;

    public function rules()
    {
        return [
            ['password', 'string', 'min' => 6, 'max' => 255],
            ['repeatPassword', 'string', 'min' => 6, 'max' => 255],
            ['repeatPassword','compare','compareAttribute'=>'password'],
        ];
    }
}
