<?php
namespace app\rbac;

use Yii;
use yii\rbac\Rule;

class UserGroupRule extends Rule
{
    public $name = 'userGroup';

    public function execute($user, $item, $params)
    {
        if (!\Yii::$app->user->isGuest) {
            $group = \Yii::$app->user->identity->status;
            if ($item->name === 'admin') {
                return $group == 'admin';
            } elseif ($item->name === 'moder') {
                return $group == 'admin' || $group == 'moder';
            } elseif ($item->name === 'user') {
                return $group == 'admin' || $group == 'moder' || $group == 'user';
            }
        }/* else {
            if ($item->name === 'guest') {
                $group = \Yii::$app->user->identity->status;
                return $group == 'admin' || $group == 'moder' || $group == 'user' || $group == 'guest';
            }
        }*/
        return true;
    }
}
