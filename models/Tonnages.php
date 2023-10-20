<?php

namespace app\models;

use yii\db\ActiveRecord;

class Tonnages extends ActiveRecord
{
    public static function tableName()
    {
        return 'tonnages';
    }

    public function rules()
    {
        return [
            [['value'], 'integer'],
        ];
    }


    public function attributeLabels(): array
    {
        return [
            'value' => 'Кол-во тонн',
        ];
    }

    static function getListForSelect()
    {
        $model = self::find()->all();

        foreach ($model as $value) {
            $array[$value->id] = $value->value;
        }

        return $array;
    }
}
