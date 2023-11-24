<?php

namespace app\commands;

use app\models\Calculation;
use Yii;
use yii\console\Controller;
use app\models\User;
use app\rbac\rules\UserRule;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        $auth->removeAll();

        $guest = $auth->createRole('guest');
        $auth->add($guest);

        $user = $auth->createRole('user');
        $auth->add($user);

        $admin = $auth->createRole('admin');
        $auth->add($admin);

        // Создание правила
        // $userRule = new UserRule();
        // $auth->add($userRule);

        $guestPermission = $auth->createPermission('guestPermit');
        $guestPermission->description = 'пути доступные начиная с guest';
        $auth->add($guestPermission);

        // Создание разрешений
        $guestPermissions = [
            '/site/*' => 'Гостевой доступ',
            '/api/*' => 'Доступ к api',
            '/debug/*' => 'Доступ к отладочным маршрутам',
        ];

        foreach ($guestPermissions as $permission => $description) {
            $perm = $auth->createPermission($permission);
            $perm->description = $description;
            $auth->add($perm);
            $auth->addChild($guestPermission, $perm);
        }

        $userPermission = $auth->createPermission('userPermit');
        $userPermission->description = 'пути доступные начиная с user';
        $auth->add($userPermission);

        // Создание разрешений
        $userPermissions = [
            '/calculation/*' => 'Доступ к маршрутам расчетов',
            '/profile/*' => 'Доступ к маршрутам профиля',
        ];

        foreach ($userPermissions as $permission => $description) {
            $perm = $auth->createPermission($permission);
            $perm->description = $description;
            $auth->add($perm);
            $auth->addChild($userPermission, $perm);
        }

        $adminPermission = $auth->createPermission('adminPermit');
        $adminPermission->description = 'пути доступные только для админа';
        $auth->add($adminPermission);

        $adminRoutes = [
            '/admin/*' => 'Доступ к маршрутам админа',
            '/gii/*' => 'Доступ к маршрутам gii',
            '/user/*' => 'Доступ к управлению пользователями',
            '/swagger-ui/*' => 'Доступ к сваггеру',
        ];
        foreach ($adminRoutes as $permission => $description) {
            $perm = $auth->createPermission($permission);
            $perm->description = $description;
            $auth->add($perm);
            $auth->addChild($adminPermission, $perm);
        }

        $auth->addChild($user, $guest);
        $auth->addChild($admin, $user);
        $auth->addChild($admin, $adminPermission);
        $auth->addChild($user, $userPermission);
        $auth->addChild($guest, $guestPermission);

        $first_user = new User();
        $first_user->username = 'tony';
        $first_user->email = 't@t.t';
        $first_user->password_hash = Yii::$app->security->generatePasswordHash('mwwbohp1');
        $first_user->auth_key = Yii::$app->security->generateRandomString();
        $first_user->save();

        $adminRole = $auth->getRole('admin');
        $auth->assign($adminRole, $first_user->getId());
    }

    ////////////////////////////////////////////////////////////

    public function actionDrop()
    {
        Yii::$app->authManager->removeAll();
        User::deleteAll();
        Calculation::deleteAll();
    }
}
