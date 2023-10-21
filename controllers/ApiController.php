<?php

namespace app\controllers;

use app\models\CalculatePrice;
use app\models\GetData;
use yii\rest\Controller;

class ApiController extends Controller
{
    public function actionGetData()
    {
        $model = new GetData();
        $expected_values = ['month', 'raw', 'tonnage'];
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if (\Yii::$app->request->get()) {
            if (
                in_array($_GET['type'], $expected_values)
            ) {
                return $model->getPrices()[$_GET['type']];;
            }
        }

        throw new \yii\web\HttpException(418, "ПЕЙ ЧАЙ");
    }

    public function actionCalculatePrice()
    {
        $model = new CalculatePrice();
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $request = \Yii::$app->request;
        if ($request->isPost && $request->getRawBody()) {
            $data = json_decode($request->getRawBody(), true);
            if (
                (isset($data['raw']) &&
                    isset($data['month']) &&
                    isset($data['tonnage']))
            ) {
                return $model->calculatePriceRes();
            }
        }
        throw new \yii\web\HttpException(418, "ПЕЙ ЧАЙ");
    }
}
