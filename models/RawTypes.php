<?php

namespace app\models;

use yii\db\ActiveRecord;

class RawTypes extends ActiveRecord
{
    public static function tableName()
    {
        return 'raw_types';
    }

    public function rules()
    {
        return [
            [['name'], 'string'],
            [['id'], 'integer'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'name' => 'Название',
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
