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
        $prices = $model->getPrices();
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if (\Yii::$app->request->get()) {
            if (count($_GET) < 1) {
                return $prices;
            }
            if (
                !isset($_GET['type']) &&
                isset($_GET['month']) &&
                isset($prices['month'][$_GET['month']])
            ) {
                $res = [];
                $raws = $prices['raw'];
                $months = $prices['month'];
                foreach ($prices as $key => $value) {
                    foreach ($raws as $raws_key => $raws_value) {
                        if ($key === $raws_key) {
                            foreach ($months as $month_key => $month_value) {
                                if ($month_key === $_GET['month'])
                                    $res[$key] = $prices[$key][$month_key];
                            }
                        }
                    }
                }
                return $res;
                $res = $prices['month'];
                return $raws;
            }

            if (
                isset($_GET['type']) &&
                !isset($_GET['month']) &&
                isset($prices[$_GET['type']])
            ) {
                $res = [];
                $raws = $prices['raw'];
                $months = $prices['month'];
                foreach ($prices as $key => $value) {
                    if ($key === $_GET['type']) {
                        $res[$key] = $prices[$_GET['type']];
                    }
                }
                return $res;
            }
            if (
                !isset($_GET['type']) &&
                !isset($_GET['month']) &&
                isset($_GET['raw']) &&
                isset($prices[$_GET['raw']])
            ) {
                $res = [];
                foreach ($prices as $key => $value) {
                    if ($key === $_GET['raw']) {
                        $res[$key] = $value;
                    }
                }
                return $res;
            }
        } else {
            $res = [];
            $raws = $prices["raw"];
            foreach ($raws as $raw_key => $raw_value) {
                foreach ($prices as $key => $value) {
                    if ($key === $raw_key) {
                        $res[$key] = $value;
                    }
                }
            }
            return $res;
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
