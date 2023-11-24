<?php

namespace app\controllers;

use yii\web\Controller;

class SpaController extends Controller
{
    public function actionIndex()
    {
        return require_once \Yii::getAlias('@app/web/index.html');
    }
}