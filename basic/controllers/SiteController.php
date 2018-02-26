<?php

namespace app\controllers;

use app\models\TestForm;
use app\models\Test;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\web\UploadedFile;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

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

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
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
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionTest()
    {
        $model = new TestForm();
        $db = new Test;
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->images = UploadedFile::getInstances($model, 'images');
            $images = $model->upload();

            // save data to DB
            $db->name = $model->name;
            $db->email = $model->email;
            $db->age = $model->age;
            $db->height = $model->height;
            $db->weight = $model->weight;
            $db->city = $model->city;
            $db->technique = $model->technique;
            $db->english = $model->english;
            $db->images = json_encode($images);
            $db->save();

            // send email
            $email_body = '<b>Name:</b> '.$model->name.'<br>';
            $email_body .= '<b>Age:</b> '.$model->age.'<br>';
            $email_body .= '<b>Height:</b> '.$model->height.'<br>';
            $email_body .= '<b>Weight:</b> '.$model->weight.'<br>';
            $email_body .= '<b>City:</b> '.$model->city.'<br>';
            $email_body .= '<b>Technique:</b> '.$model->getCheckboxLabels('technique', $model->technique).'<br>';
            $email_body .= '<b>English:</b> '.$model->getCheckboxLabels('english', $model->english).'<br>';


            Yii::$app->mailer->compose('layouts/test', ['images' => $images] )
                ->setFrom('test@gmail.com')
                ->setTo($db->email)
                ->setSubject('Test form')
                ->setHtmlBody($email_body)
                ->send();

            return $this->render('success');
        } else {
            return $this->render('test', ['model' => $model]);
        }
    }
}
