<?php


namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class AddImg extends Model
{
    public $imageFile;


    public function rules()
    {
        return [
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
        ];
    }

    public function upload()
    {
        $imageName = time();
        $this->imageFile = UploadedFile::getInstance($this, 'imageFile');
        $this->imageFile->saveAs('../web/converts/offer/'.Yii::$app->user->identity->username.'_'.$imageName.'.'.$this->imageFile->extension);
        return true;

    }
}