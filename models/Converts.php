<?php


namespace app\models;

use phpDocumentor\Reflection\Types\This;
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class Converts extends ActiveRecord
{

    public static function tableName()
    {
        return '{{converts}}';
    }

    public static function searchConvert(){

      $count = Converts::find()
           ->where(['user_id'=>Yii::$app->user->identity->username])
           ->count();
      if ($count){
          return $count;
      }
      else {
          return intval('0');
      }

    }

    public static function checkConvert($num_convert){

        $check = Converts::find()->where(['num_convert' => $num_convert,'user_id' => Yii::$app->user->identity->username ])->one();
        if (empty($check)) {
            return $num_convert;
        }
        else return false;
    }

    public static function addImg($path_img, $num_convert){

        $convert = Converts::find()->where(['num_convert' => $num_convert,'user_id' => Yii::$app->user->identity->username ])->one();
        $convert->img_convert = $path_img;
        return $convert->save() ? $convert : null;
    }

    public static function addSrc($src, $num_convert){

        $convert = Converts::find()->where(['num_convert' => $num_convert,'user_id' => Yii::$app->user->identity->username ])->one();
        $convert->src = $src;
        return $convert->save() ? $convert : null;
    }




}