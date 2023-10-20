<?php

namespace app\controllers;

use app\models\GetData;
use app\models\CalculatePrice;
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
                $prices = $model->getPrices();
                $res = $prices[$_GET['type']];
                return $res;
            }
        }

        // throw new \yii\web\BadRequestHttpException("Bad Request");
        throw new \yii\web\HttpException(418, "ПЕЙ ЧАЙ");
    }

    public function actionCalculatePrice()
    {
        $model = new CalculatePrice();
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $request = \Yii::$app->request;
        if ($request->isPost && $request->getRawBody()) {
            $data = json_decode($request->getRawBody(), true);
            // dd($data);
            if (
                (isset($data['raw']) &&
                    isset($data['month']) &&
                    isset($data['tonnage'])) &&
                isset(
                    $model->getPrices()[$data['raw']][$data['month']][$data['tonnage']]
                )
            ) {
                $res = [];
                $res['price'] = $model->getPrices()[$data['raw']][$data['month']][$data['tonnage']];
                $res['price_list'][$data['raw']] = $model->getPrices()[$data['raw']];
                // $model->getPrices()[$data['raw']]
                return $res;
            }
        }
        throw new \yii\web\HttpException(418, "ПЕЙ ЧАЙ");
        // throw new \yii\web\BadRequestHttpException("Bad Request");
    }
}
