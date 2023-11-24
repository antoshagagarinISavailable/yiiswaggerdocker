<?php

namespace app\rbac\rules;

use yii\rbac\Rule;

class UserRule extends Rule
{
    public $name = 'userRule';

    public function execute($user, $item, $params)
    {
        if (isset($params['route'])) {
            $allowedRoutes = ['/site/*', '/calculation/*', '/user/profile', '/api/*'];
            return in_array($params['route'], $allowedRoutes);
        }
        return false;
    }
}
