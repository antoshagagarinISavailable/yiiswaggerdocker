<?php

namespace app\models;

use yii\db\ActiveRecord;

class Months extends ActiveRecord
{

    public function rules()
    {
        return [
            [['month'], 'string'],
            [['percent'], 'integer'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'name' => 'Месяц',
        ];
    }

    static function getListForSelect()
    {
        $model = self::find()->all();

        foreach ($model as $value) {
            $array[$value->id] = $value->name;
        }

        return $array;
    }
}
