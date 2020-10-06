<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\Converts;
use app\models\SignupForm;
use app\models\ConvertModel;
use app\models\PasswordResetRequestForm;
use app\models\ResetPasswordForm;
use app\models\AccessUser;
use app\models\LetterModal;
use app\models\ReadyConvert;
use yii\base\InvalidParamException;
use app\models\AddImg;


class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

//    public function beforeAction($action)
//    {
//        if (parent::beforeAction($action)) {
//            if (!\Yii::$app->user->can($action->id)) {
//                throw new ForbiddenHttpException('Access denied');
//            }
//            return true;
//        } else {
//            return false;
//        }
//    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {

        return $this->render('index');
    }

    public function actionAdmin()
    {
        if (!\Yii::$app->user->can('admin'))
        {
            throw new ForbiddenHttpException('Админка для админа');
        }
        return $this->render('admin');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {

        if (\Yii::$app->user->can('updateNews'))
        {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionCount()
    {
        $model = Converts::searchConvert();
        return intval($model)+1;
    }

    public function actionAddimg()
    {
        $model = new AddImg();
        if (Yii::$app->request->isAjax) {
            $path_img = $_POST['path_img'];
            $num_convert = $_POST['num_convert'];
            $add = Converts::addImg($path_img, $num_convert);
            if ($add){
                return true;
            }
            else return false;

        }
        return $this->render('Convert', [
            'model' => $model,
        ]);

    }

    public function actionAddoffer()
    {
        $model = new AddImg();
        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

                if ($letter = $model->upload()) {
                    return true;
                }
            }

        }
        return false;
    }

    public function actionAddletter()
    {

        $model= new LetterModal();
        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

                if ($letter = $model->addLetter()) {
                    return true;
                }
                }

            }
        return false;

    }
    public function actionCreateconvert()
    {
        $model= new ReadyConvert();
        $num_conv = $_POST['convert'];
        if ($model = $model->createConvert($num_conv)) {
           return true;
        }
        else return false;
    }

    public function actionKohbept()
    {
        $model= new ReadyConvert();
        $num_conv = $_GET['convert'];
        if ($model = $model->getSrc($num_conv)) {
            return $this->render('Kohbept', [
                'model' => $model,
            ]);
        }
        else return false;
    }


    public function actionShare()
    {
        if (!empty($_GET['link'])){
            $link = $_GET['link'];
            $model= new ReadyConvert();
            if ($model = $model->getConvertik($link)) {
                return $this->render('Share', [
                    'model' => $model,
                ]);
            }
            else return false;
        }
        else return false;
    }

    public function actionCreatelink()
    {
        $model= new ReadyConvert();
        $num_conv = $_POST['convert'];
        if ($model = $model->getLink($num_conv)) {
            return $this->asJson($model);
        }
        else return false;
    }



    public function actionConvert()
    {
        if (!\Yii::$app->user->can('updateNews'))
        {
            return $this->goHome();
        }
        $model_letter = new LetterModal();
        $model = new ConvertModel();
        $model_img = new AddImg();
        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

                if ($convert = $model->addDataConvert()) {
                    Yii::$app->session->setFlash('success', 'Теперь выберите конверт');
                }

            }
        }

        return $this->render('convert', [
            'model' => $model,
            'model_letter'=>$model_letter,
            'model_img'=>$model_img,
        ]);
    }

    public function actionSignup()
    {
        $model = new SignupForm();

        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    Yii::$app->session->setFlash('success', 'Ожидайте разрешение от администратора...');
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Проверьте вашу почту');
                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Мы не смогли отправить сообщение вам на почту.   ');
            }
        }

        return $this->render('PasswordResetRequestForm', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'Новый пароль сохранен');
            return $this->goHome();
        }

        return $this->render('resetPasswordForm', [
            'model' => $model,
        ]);
      }

    public function actionAccessUser()
    {

        $token = $_GET['token'];
        $model = new AccessUser();
        if ($model->resetStatus($token)) {
            Yii::$app->session->setFlash('success', 'Добавлен новый пользователь');
            return $this->goHome();
        }
        Yii::$app->session->setFlash('error', 'Ошибка');
        return $this->render('AccessUserForm', [
            'model' => $model,
        ]);
    }




}
