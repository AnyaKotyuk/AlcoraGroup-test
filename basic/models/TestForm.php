<?php

namespace app\models;

use Yii;
use yii\base\Model;

class TestForm extends Model
{
    public $name;
    public $email;
    public $age;
    public $height;
    public $weight;
    public $city;

    public function rules()
    {
        return [
            [['name', 'email'], 'required'],
            ['email', 'email'],
        ];
    }
}