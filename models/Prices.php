<?php

namespace app\models;

use yii\db\Query;
use yii\db\ActiveRecord;

class Prices extends ActiveRecord
{

    public function getCalcRes()
    {
        return (new Query())
            ->select(['raw_types.name as raw', 'months.name as month', 'price', 'tonnages.value as tonnage'])
            ->from('months')
            ->innerJoin('prices', 'months.id = prices.month_id')
            ->innerJoin('tonnages', 'tonnages.id = prices.tonnage_id')
            ->innerJoin('raw_types', 'raw_types.id = prices.raw_type_id')
            ->where(['raw_type_id' => $this->raw_type_id])
            ->andWhere(['tonnage_id' => $this->tonnage_id])
            ->andWhere(['month_id' => $this->month_id])
            ->orderBy(['tonnages.value' => SORT_ASC, 'months.id' => SORT_ASC])
            ->one();
    }

    public function dataForTable()
    {
        return (new Query())
            ->select(['price', 'months.name', 'tonnages.value'])
            ->from('months')
            ->innerJoin('prices', 'months.id = prices.month_id')
            ->innerJoin('tonnages', 'tonnages.id = prices.tonnage_id')
            ->innerJoin('raw_types', 'raw_types.id = prices.raw_type_id')
            ->where(['raw_type_id' => $this->raw_type_id])
            ->orderBy(['tonnages.value' => SORT_ASC, 'months.id' => SORT_ASC])
            ->all();
    }

    public function allMonths()
    {
        return Months::getListForSelect();
    }

    public function allTonnages()
    {
        return Tonnages::getListForSelect();
    }

    public function allRaws()
    {
        return RawTypes::getListForSelect();
    }

    public function rules()
    {
        return [
            [['month_id', 'tonnage_id', 'raw_type_id'], 'required'],
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
