<?php
namespace app\controllers;

use app\models\Test;
use Yii;
use yii\web\Controller;
use yii\web\UploadedFile;

class TestController extends Controller
{
    public function actionSuccess($id)
    {
        $model = Test::findOne($id);
        return $this->render('success', ['user_data' => $model]);
    }

    public function actionForm()
    {
        $model = new Test();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $images = UploadedFile::getInstances($model, 'images');
            $images = $model->upload($images);

            // save data to DB
            $model->images = json_encode($images);
            $model->save();

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
                ->setTo($model->email)
                ->setSubject('Test form')
                ->setHtmlBody($email_body)
                ->send();


            return $this->redirect(['success', 'id' =>$model->id ]);
        } else {
            return $this->render('test', ['model' => $model]);
        }
    }
}
