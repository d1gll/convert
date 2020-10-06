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
        $path = '../web/converts/'; // - путь до создаваемой папки.
        $mode = '0755';               // - права на создаваемую папку.
        $recursive = true;            // - несуществующие папки будут воссозданы.
        if (!file_exists($path. 'offer')) {
            mkdir($path . 'offer', $mode, $recursive);
        }
        $this->imageFile->saveAs('../web/converts/offer/'.Yii::$app->user->identity->username.'_'.$imageName.'.'.$this->imageFile->extension);
        return true;

    }
}
