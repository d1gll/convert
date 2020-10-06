<?php


namespace app\models;


use yii\base\Model;
use Yii;
use yii\imagine\Image;


class ReadyConvert extends Model
{


    public function rules()
    {
        return [

        ];
    }

    public function getConvert($num_conv){
       $convert = Converts::find()->where(['num_convert' => $num_conv,'user_id' => Yii::$app->user->identity->username ])->one();
       return array($convert);
    }

    public static function getConvertik($link){

        $convert = Converts::find()->where(['link' => $link])->one();
        $str = preg_replace('/\s+/', '', $convert->user_id);
        $src_convert = '../web/converts/'.$str.'/convert_'.$convert->num_convert.'.jpg';
        $src_letter = '../web/converts/'.$str.'/letter_'.$convert->num_convert.'.jpg';
        return array($src_convert, $src_letter);
    }

    public function getSrc($num_conv){
        $convert = Converts::find()->where(['num_convert' => $num_conv,'user_id' => Yii::$app->user->identity->username ])->one();
        $src = $convert->src;
        return $src;
    }
    public function getLink($num_conv){
        $convert = Converts::find()->where(['num_convert' => $num_conv,'user_id' => Yii::$app->user->identity->username ])->one();
        $link = 'http://localhost/web/index.php?r=site%2Fshare&link='.$convert->link;
        return $link;
    }

    public function EditImg($src, $image, $text, $fontFile, $start, $fontOptions)
    {
        Image::text(
            $image,    // Картинка, на которой рисуем текст
            $text,     // Текст
            $fontFile, // Путь к файлу шрифта
            $start,    // Отступ от левого края картинки в 100px, от верхнего в 200px
            $fontOptions
        )->save(Yii::getAlias('@webroot/converts/'.$src), ['quality' => 80]);
    }


    public function createConvert($num_conv)
    {

        $model = self::getConvert($num_conv);
        foreach($model as $val)
        {
            $path = $val->img_convert;
            $filename = substr(strrchr($path, "converts"), 0);

            $filename =strtok($filename, '.');
            $number = substr(strrchr($filename, "_"), 1);



        $temp_convert = 'convert_'.$filename;
        $user = trim($val->user_id);

            $path = '../views/web/converts/'; // - путь до создаваемой папки.
            $mode = '0755';               // - права на создаваемую папку.
            $recursive = true;            // - несуществующие папки будут воссозданы.
            if (!file_exists($path. $user)) {
                mkdir($path . $user, $mode, $recursive);
            }
                $src=$user.'/convert_'.$val->num_convert.'.jpg';
                $fontFile = Yii::getAlias('@webroot/arial.ttf');
                $fontOptions = [
                    'size'  => 10,    // Размер шрифта
                    'color' => '000', // цвет шрифта
                    'angle' => 0   // Угол 90 градусов
                ];


        //От кого
        $image = Yii::getAlias('@webroot/converts/'.$filename.'.jpg');
        $text = $val->name_out;
        switch ($number)
        {
            case '1':
                $start = [130, 145];
                break;
            case '2':
                $start = [330, 97];
                break;
            case '3':
                $start = [235, 380];
                $fontOptions = [
                    'size'  => 15,    // Размер шрифта
                    'color' => '000', // цвет шрифта
                    'angle' => 0,
                    'letter-spacing' => '10px',
                ];
                break;
        }
            self::EditImg($src, $image, $text, $fontFile, $start, $fontOptions);

        //Откуда
                $image = Yii::getAlias('@webroot/converts/'.$src);
                $src1 = Yii::getAlias('@webroot/converts/'.$src);
                $text =  wordwrap($val->adress_out, 50);
            switch ($number)
            {
                case '1':
                    $start = [130, 190];
                    break;
                case '2':
                    $start = [330, 117];
                    break;
                case '3':
                    $start = [235, 410];
                    break;
            }

            self::EditImg($src, $image, $text, $fontFile, $start, $fontOptions);

        //Индекс отправителя
                $image = Yii::getAlias('@webroot/converts/'.$src);
                $text = $val->index_out;
            switch ($number)
            {
                case '1':
                    $start = [235, 235];
                    break;
                case '2':
                    $start = [440, 157];
                    break;
                case '3':
                    $start = [450, 498];
                    break;
            }

            self::EditImg($src, $image, $text, $fontFile, $start, $fontOptions);

        //Кому
                $image = Yii::getAlias('@webroot/converts/'.$src);
                $text = $val->name_in;
            switch ($number)
            {
                case '1':
                    $start = [440, 370];
                    break;
                case '2':
                    $start = [310, 173];
                    break;
                case '3':
                    $start = [635, 612];
                    break;
            }

            self::EditImg($src, $image, $text, $fontFile, $start, $fontOptions);

        //Куда
                $image = Yii::getAlias('@webroot/converts/'.$src);
                $text =  wordwrap($val->adress_in, 50);
            switch ($number)
            {
                case '1':
                    $start = [440, 420];
                    break;
                case '2':
                    $start = [310, 217];
                    break;
                case '3':
                    $start = [635, 678];
                    break;
            }

            self::EditImg($src, $image, $text, $fontFile, $start, $fontOptions);

        //Индекс полчателя
                $image = Yii::getAlias('@webroot/converts/'.$src);
                $text = $val->index_in;
            switch ($number)
            {
                case '1':
                    $start = [430, 485];
                    break;
                case '2':
                    $start = [300, 297];
                    break;
                case '3':
                    $start = [620, 796];
                    break;
            }

                self::EditImg($src, $image, $text, $fontFile, $start, $fontOptions);
            $letter = $val->letter;
            $image = Yii::getAlias('@webroot/converts/List.jpg');
            $fontFile = Yii::getAlias('@webroot/Pacifico-Regular.ttf');
            $text = wordwrap($letter, 95);
            $start = [150, 170];
            $src = $user.'/letter_'.$val->num_convert.'.jpg';
            $fontOptions = [
                'size'  => 17,    // Размер шрифта
                'color' => '000', // цвет шрифта
                'angle' => 0    // Угол 90 градусов
            ];
            self::EditImg($src, $image, $text, $fontFile, $start, $fontOptions);


        }
        $num_convert = $val->num_convert;

        $pdf = self::createPDF($user,$num_convert);
        if ($pdf) {
            return true;
        }
        else return false;


    }

    public function createPDF($user,$num_convert){


        $src_convert = Yii::getAlias('@webroot/converts/'.$user.'/convert_'.$num_convert.'.jpg');
        $src_letter = Yii::getAlias('@webroot/converts/'.$user.'/letter_'.$num_convert.'.jpg');
        $images = array($src_convert,$src_letter);
        $src = Yii::getAlias('@webroot/converts/'.$user.'/letter_'.$num_convert.'.pdf');
        $pdf = new \Imagick($images);
        $pdf->setImageFormat('pdf');
        $pdf->writeImages($src, true);
        $src = '../web/converts/'.$user.'/letter_'.$num_convert.'.pdf';
        $add = Converts::addSrc($src, $num_convert);
        if ($add) {
            return true;
        }
        else return false;

    }
}