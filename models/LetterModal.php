<?php


namespace app\models;

use Yii;
use yii\base\Model;

class LetterModal extends Model
{
    public $letter;
    public $num_convert1;


    public function rules()
    {
        return [
            [['num_convert1', 'letter'], 'required', 'message' => 'Заполните поле'],
            ['letter', 'trim'],
            ['letter', 'trim'],
            ['letter', 'string', 'max' => 700],

        ];
    }

    public function addLetter(){
        $convert = Converts::find()->where(['num_convert' => $this->num_convert1,'user_id' => Yii::$app->user->identity->username ])->one();
        $convert->letter = $this->letter;
        return $convert->save() ? $convert : null;
    }

}