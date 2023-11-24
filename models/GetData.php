<?php

namespace app\models;

use yii\base\Model;

class GetData extends Model
{
    public $raw;
    public $month;
    public $tonnage;

    public function getPrices()
    {
        return [
            'month' => Months::getListForSelect(),
            'tonnage' =>  Tonnages::getListForSelect(),
            'raw' => RawTypes::getListForSelect(),
        ];
    }
}
