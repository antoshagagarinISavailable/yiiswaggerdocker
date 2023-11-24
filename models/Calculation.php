<?php

namespace app\models;

use yii\db\ActiveRecord;

class Calculation extends ActiveRecord
{
    public static function tableName()
    {
        return 'calculations';
    }

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
    public static function addCalculation(array $params)
    {
        $calculation = new Calculation();
        $calculation->table_data = json_encode($params['dataForTable']);
        $calculation->user = \Yii::$app->user->identity->username;
        $calculation->user_id = \Yii::$app->user->id;
        $calculation->month = $params['calc_res']['month'];
        $calculation->type = $params['calc_res']['raw'];
        $calculation->tonnage = $params['calc_res']['tonnage'];
        $calculation->result = $params['calc_res']['price'];
        $calculation->all_months = json_encode($params['all_months']);
        $calculation->all_tonnages = json_encode($params['all_tonnages']);
        $calculation->save();
    }
}
