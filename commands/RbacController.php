<?php

namespace app\commands;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;


        // добавляем роль "admin"
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $user = $auth->createRole('user');
        $auth->add($user);


        // $auth->assign($admin, 1);
    }
}
