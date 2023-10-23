<?php

namespace app\models;

use yii\base\Model;
use yii\db\Query;

use function PHPSTORM_META\type;

class CalculatePrice extends Model
{
    public $raw;
    public $month;
    public $tonnage;

    public static function tableName()
    {
        return 'prices';
    }

    public function getAllMonths()
    {
        $arr = Months::getListForSelect();
        $res = [];
        foreach ($arr as $key => $value) {
            $res[] = $value;
        }
        return $res;
    }

    public function getAllRaws()
    {
        return RawTypes::getListForSelect();
    }

    public function getAllTonnages()
    {
        $arr = Tonnages::getListForSelect();
        $res = [];
        foreach ($arr as $key => $value) {
            $res[] = $value;
        }
        return $res;
    }


    public function calculatePrice($data)
    {
        return (new Query())
            ->select(['price'])
            ->from('prices')
            ->where([
                'month_id' => (new Query())->select('id')->from('months')->where(['name' => $data['month']]),
                'tonnage_id' => (new Query())->select('id')->from('tonnages')->where(['value' => $data['tonnage']]),
                'raw_type_id' => (new Query())->select('id')->from('raw_types')->where(['name' => $data['type']]),
            ])
            ->one() ?: false;
    }


    public function calculatePriceRes()
    {
        $request = \Yii::$app->request;
        $data = json_decode($request->getRawBody(), true);

        if (gettype($data) !== 'array') {
            $data = $request->getQueryString();
            $decodedData = urldecode($data);

            // Разбиваем строку на пары ключ-значение
            $pairs = explode('&', $decodedData);

            // Создаем ассоциативный массив для хранения значений
            $values = array();

            // Разбиваем каждую пару на ключ и значение
            foreach ($pairs as $pair) {
                $keyValue = explode('=', $pair);
                $key = $keyValue[0];
                $value = $keyValue[1];
                $values[$key] = $value;
            }
            $data = $values;
        }

        $res['price'] = $this->calculatePrice($data)['price'] ?? 'There\'s no price for the chosen weight';

        foreach ($this->getAllMonths() as $month) {
            foreach ($this->getAllTonnages() as $tonnage) {
                $res['price_list'][$data['type']][$month][$tonnage] =
                    $this->calculatePrice(['type' => $data['type'], 'month' => $month, 'tonnage' => $tonnage])['price'];
            }
        }

        return $res;
    }
    public function arrayHelper($arr)
    {
        $res = [];
        foreach ($arr as $key => $value) {
            $res[$value] = $value;
        }
        return $res;
    }
    public function rules()
    {
        return [
            [['month_id', 'tonnage_id', 'raw_type_id'], 'required'],
        ];
    }
}
