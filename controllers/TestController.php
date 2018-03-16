<?php

namespace app\controllers;

use app\models\TestForm;
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


            return $this->redirect(['success', 'id' =>$db->id ]);
        } else {
            return $this->render('test', ['model' => $model]);
        }
    }
}
