<?php

namespace app\controllers;

use app\models\CalculatePrice;
use app\models\Months;
use app\models\Tonnages;
use app\models\RawTypes;
use app\models\GetData;
use yii\rest\Controller;
use yii\web\Response;
use Yii;


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
                (isset($data['type']) &&
                    isset($data['month']) &&
                    isset($data['tonnage']))
            ) {
                return $model->calculatePriceRes();
            }
        }
        throw new \yii\web\HttpException(418, "ПЕЙ ЧАЙ");
    }
    public function actionGetSpec()
    {
        Yii::$app->response->format = Response::FORMAT_RAW;
        Yii::$app->response->headers->set('Content-type', 'application/x-yaml');

        ob_start();

        include_once Yii::getAlias('@app') . '/swagger/spec.yml';

        return ob_get_clean();
    }

    public function actionGetMonths()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = new Months();
        return $model->getListForSelect();
    }
    public function actionGetTypes()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = new RawTypes();
        return $model->getListForSelect();
        throw new \yii\web\HttpException(418, "ПЕЙ ЧАЙ");
    }
    public function actionGetTonnages()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = new Tonnages();
        return $model->getListForSelect();
        throw new \yii\web\HttpException(418, "ПЕЙ ЧАЙ");
    }
    public function actionGetCalculate()
    {
        $model = new CalculatePrice();
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $request = \Yii::$app->request;
        if ($request) {
            return $model->calculatePriceRes();
        }
        throw new \yii\web\HttpException(418, "ПЕЙ ЧАЙ");
    }
    public function actionSetMonth()
    {
        dd(
            Yii::$app->getRequest()->getBodyParams(),
            Yii::$app->request->post()
        );
        $model = new CalculatePrice();
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $request = \Yii::$app->request;
        if ($request) {
            return $model->calculatePriceRes();
        }
        throw new \yii\web\HttpException(418, "ПЕЙ ЧАЙ");
    }
}
