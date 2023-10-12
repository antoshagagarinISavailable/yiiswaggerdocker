<?php

namespace app\models;

use yii\base\Model;

class CalculatePrice extends Model
{
    public $raw;
    public $month;
    public $tonnage;
    public function getPrices()
    {
        if (is_file(__DIR__ . '/../config/prices.php')) {
            $res = require __DIR__ . '/../config/prices.php';
            return $res;
        } else exit('файл config/prices.php не найден');
    }
}
