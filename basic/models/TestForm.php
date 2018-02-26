<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\helpers\FileHelper;

class TestForm extends Model
{
    public $name;
    public $email;
    public $age;
    public $height;
    public $weight;
    public $city;
    public $technique;
    public $english;
    public $images;

    public function rules()
    {
        return [
            [['name', 'email', 'height', 'city', 'english', 'technique', 'age', 'weight'], 'required'],
            ['email', 'email'],
            [['age', 'weight'], 'number'],
            [['images'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg', 'maxFiles' => 5],
        ];
    }

    /**
     * Uploading files from user form
     *
     * @return bool
     */
    public function upload()
    {
        $images = [];
        if ($this->validate()) {
            foreach ($this->images as $file) {
                FileHelper::createDirectory('uploads');
                $file->saveAs('uploads/' . $file->baseName . '.' . $file->extension);
                $images[] = $file->baseName . '.' . $file->extension;
            }
            return $images;
        } else {
            return false;
        }
    }

    /**
     * Get checkboxses values (labels)
     *
     */
    public function getCheckboxLabels($ch = '', $val = ''){
        $values = array(
            'technique' => array(
                'no' => 'нет',
                'camera' => 'да, только камера',
                'yes' => 'да, компьютер и камера'
            ),
            'english' => array(
                'no' => 'без знания',
                'basic' => 'базовый',
                'intermediate' => 'средний',
                'fluent' => 'превосходный',
            )
        );
        return (!empty($values[$ch][$val]))?$values[$ch][$val]:'';
    }
}