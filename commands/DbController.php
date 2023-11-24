<?php

namespace app\commands;

use Yii;
use yii\console\Controller;

class DbController extends Controller
{
    public function actionReset()
    {
        $db = Yii::$app->db;
        $dbName = $db->createCommand("SELECT DATABASE()")->queryScalar();
        $db->createCommand("DROP DATABASE IF EXISTS $dbName")->execute();
        $db->createCommand("CREATE DATABASE $dbName")->execute();

        $db->close();
        $db->dsn .= ';dbname=' . $dbName;
        $db->open();

        $migrationController = new \yii\console\controllers\MigrateController('migrate', Yii::$app);
        $migrationController->runAction('up');
        $migrationController->runAction('up', ['migrationPath' => '@mdm/admin/migrations']);
        $migrationController->runAction('up', ['migrationPath' => '@yii/rbac/migrations']);
    }
}
