<?php

namespace app\commands;

use app\models\CalculatePrice;
use Symfony\Component\VarDumper\VarDumper;
use yii\console\Controller;
use yii\console\ExitCode;
use Yii;

class CalcController extends Controller
{
    public $month;
    public $type;
    public $tonnage;

    public function options($actionID)
    {
        return ['month', 'type', 'tonnage'];
    }

    public function actionIndex()
    {
        $data = Yii::$app->request->params;
        $values = array();

        foreach ($data as $key => $pair) {
            if (strpos($pair, '=') !== false) {
                $keyValue = explode('=', $pair);
                $key = $keyValue[0];
                $value = $keyValue[1];
                $values[$key] = $value;
            }
        }
        $data = $values;
        $this->month = $data['month'] ?? null;
        $this->tonnage = $data['tonnage'] ?? null;
        $this->type = $data['type'] ?? null;

        $model = new CalculatePrice();
        $types = $model->arrayHelper($model->getAllRaws());
        $months = $model->arrayHelper($model->getAllMonths());
        $tonnages = $model->arrayHelper($model->getAllTonnages());

        if (!$this->month || !$this->type || !$this->tonnage) {
            echo "error:\n";
            if (!isset($this->month)) echo "MONTH required.\n";
            if (!isset($this->type)) echo "TYPE required.\n";
            if (!isset($this->tonnage)) echo "TONNAGE required.\n";
            return;
        }

        if (
            !isset($types[$this->type])
        ) {
            echo "error:\n";
            echo "price for --type=$this->type does not exist.\n";
            echo "check your input.\n";
            return;
        } else if (
            !isset($months[$this->month])
        ) {
            echo "error:\n";
            echo "price for --month=$this->month does not exist.\n";
            echo "check your input.\n";
            return;
        } else if (
            !isset($tonnages[$this->tonnage])
        ) {
            echo "error:\n";
            echo "price for --tonnage=$this->tonnage does not exist.\n";
            echo "check your input.\n";
            return;
        }

        if ($this->month && $this->type && $this->tonnage) {

            echo "month: $this->month" . "\n";
            echo "type: $this->type" . "\n";
            echo "tonnage: $this->tonnage" . "\n";
            echo 'result: ' .
                $model->calculatePrice($data)['price'];
            echo "\n";
        }
        return ExitCode::OK;
    }
}
