<?php
namespace app\commands;

use Yii;
use yii\console\Controller;
use app\rbac\UserGroupRule;

class RbacController extends Controller
{
    public function actionInit()
    {
        $authManager = \Yii::$app->authManager;

        // Create roles
        $guest  = $authManager->createRole('guest');
        $user   = $authManager->createRole('user');
        $moder  = $authManager->createRole('moder');
        $admin  = $authManager->createRole('admin');

        // Create simple, based on action{$NAME} permissions
        $login       = $authManager->createPermission('login');
        $logout      = $authManager->createPermission('logout');
        $error       = $authManager->createPermission('error');
        $signup      = $authManager->createPermission('signup');
        $site_index  = $authManager->createPermission('site_index');
        $news_view   = $authManager->createPermission('news_view');
        $news_update = $authManager->createPermission('news_update');
        $news_delete = $authManager->createPermission('news_delete');
        $news_create = $authManager->createPermission('news_create');
        $news_index  = $authManager->createPermission('news_index');
        $user_view   = $authManager->createPermission('news_view');
        $user_update = $authManager->createPermission('user_update');
        $user_delete = $authManager->createPermission('user_delete');
        $user_create = $authManager->createPermission('user_create');
        $user_index  = $authManager->createPermission('user_index');

        // Add permissions in Yii::$app->authManager
        $authManager->add($login);
        $authManager->add($logout);
        $authManager->add($error);
        $authManager->add($signup);
        $authManager->add($site_index);
        $authManager->add($news_view);
        $authManager->add($news_update);
        $authManager->add($news_delete);
        $authManager->add($news_create);
        $authManager->add($news_index);
        $authManager->add($user_view);
        $authManager->add($user_update);
        $authManager->add($user_delete);
        $authManager->add($user_create);
        $authManager->add($user_index);

        // Add rule, based on UserExt->group === $user->group
        $userGroupRule = new UserGroupRule();
        $authManager->add($userGroupRule);

        // Add rule "UserGroupRule" in roles
        $guest->ruleName  = $userGroupRule->name;
        $user->ruleName   = $userGroupRule->name;
        $moder->ruleName  = $userGroupRule->name;
        $admin->ruleName  = $userGroupRule->name;

        // Add roles in Yii::$app->authManager
        $authManager->add($guest);
        $authManager->add($user);
        $authManager->add($moder);
        $authManager->add($admin);

        // Add permission-per-role in Yii::$app->authManager
        // Guest
        $authManager->addChild($guest, $login);
        //$authManager->addChild($guest, $logout);
        $authManager->addChild($guest, $error);
        $authManager->addChild($guest, $signup);
        $authManager->addChild($guest, $site_index);

        // User
        $authManager->addChild($user, $logout);
        $authManager->addChild($user, $news_view);
        $authManager->addChild($user, $guest);

        // Moder
        $authManager->addChild($moder, $news_index);
        $authManager->addChild($moder, $news_update);
        $authManager->addChild($moder, $news_delete);
        $authManager->addChild($moder, $news_create);
        $authManager->addChild($moder, $user);

        // Admin
        $authManager->addChild($admin, $user_index);
        $authManager->addChild($admin, $user_view);
        $authManager->addChild($admin, $user_create);
        $authManager->addChild($admin, $user_update);
        $authManager->addChild($admin, $user_delete);
        $authManager->addChild($admin, $moder);
    }
}
