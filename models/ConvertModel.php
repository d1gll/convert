<?php


namespace app\models;

use Yii;
use yii\base\Model;


class ConvertModel extends Model
{
    public $name_out;
    public $adress_out;
    public $index_out;
    public $name_in;
    public $adress_in;
    public $index_in;
    public $num_convert;


    public function rules()
    {
        return [
            [['name_out', 'adress_out', 'index_out',
                'name_in', 'adress_in', 'index_in', 'num_convert'], 'required', 'message' => 'Заполните поле'],
            [['name_out', 'adress_out', 'index_out',
                'name_in', 'adress_in', 'index_in'], 'trim'],
            [['index_out', 'index_in'], 'double', 'message' => 'Индекс должен быть числом'],
            [['name_out', 'name_in'], 'string', 'min' => 2, 'max' => 50],
            [['adress_out', 'adress_in'], 'string', 'min' => 2, 'max' => 100],
            [['index_out', 'index_in'], 'string', 'min' => 6, 'max' => 6],

        ];
    }
    public function attributeLabels()
    {
        return [
            'name_out' => 'Имя отправителя',
            'adress_out' => 'От куда (адрес)',
            'index_out' => 'Индекс (отправителя)',
            'name_in' => 'Имя получателя',
            'adress_in' => 'Куда (адрес)',
            'index_in' => 'Индекс (получателя)',
        ];
    }


    public function addDataConvert(){
        if (!$this->validate()) {
            return null;
        }
        $num_convert = $this->num_convert;
        $check = Converts::checkConvert($num_convert);

        if ($check)
        {
        $convert = new Converts();
        $convert->user_id=Yii::$app->user->identity->username;
        $convert->name_out = $this->name_out;
        $convert->adress_out = $this->adress_out;
        $convert->index_out = $this->index_out;
        $convert->name_in = $this->name_in;
        $convert->adress_in = $this->adress_in;
        $convert->index_in = $this->index_in;
        $convert->num_convert = $check;
        $convert->link = Yii::$app->security->generateRandomString();
        }
        else {
            $convert = Converts::find()->where(['num_convert' => $num_convert,'user_id' => Yii::$app->user->identity->username ])->one();
            $convert->name_out = $this->name_out;
            $convert->adress_out = $this->adress_out;
            $convert->index_out = $this->index_out;
            $convert->name_in = $this->name_in;
            $convert->adress_in = $this->adress_in;
            $convert->index_in = $this->index_in;
        }
        return $convert->save() ? $convert : null;
    }


}