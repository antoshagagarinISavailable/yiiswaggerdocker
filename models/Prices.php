<?php

namespace app\models;

use PhpParser\Node\Expr\FuncCall;
use yii\db\ActiveRecord;

class Prices extends ActiveRecord
{
    public static function tableName()
    {
        return 'prices';
    }

    public function rules()
    {
        return [
            [['month_id', 'tonnage_id', 'raw_type_id', 'price'], 'integer'],
        ];
    }


    public function attributeLabels(): array
    {
        return [
            'month_id' => 'месяц',
            'tonnage_id' => 'тоннаж',
            'raw_type_id' => 'сырьё',
        ];
    }
}
