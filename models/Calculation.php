<?php

namespace app\models;

use yii\db\ActiveRecord;

class Calculation extends ActiveRecord
{
    public static function tableName()
    {
        return 'calculations';
    }

    // public function rules()
    // {
    //     return [
    //         [['month'], 'string'],
    //         [['percent'], 'integer'],
    //     ];
    // }

    public function attributeLabels(): array
    {
        return [
            'user' => 'пользователь',
            'month' => 'месяц',
            'type' => 'сырьё',
            'tonnage' => 'тоннаж',
            'result' => 'стоимость',
            'created_at' => 'создан',
        ];
    }
    public function getAllMonths()
    {
        return json_decode($this->all_months, true);
    }
    public function getAllTonnages()
    {
        return json_decode($this->all_tonnages, true);
    }
    public function getDataForTable()
    {
        return json_decode($this->table_data, true);
    }

    // static function getListForSelect()
    // {
    //     $model = self::find()->all();

    //     foreach ($model as $value) {
    //         $array[$value->id] = $value->name;
    //     }

    //     return $array;
    // }
}
