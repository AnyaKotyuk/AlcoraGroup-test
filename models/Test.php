<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\helpers\FileHelper;

class Test extends ActiveRecord
{

    /**
     * @return string the name of the table associated with this ActiveRecord class.
     */
    public static function tableName()
    {
        return '{{test}}';
    }

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
    public function upload($images = [])
    {
        $image_arr = [];
        if ($this->validate()) {
            foreach ($images as $file) {
                FileHelper::createDirectory('uploads');
                if($file->saveAs('uploads/' . $file->baseName . '.' . $file->extension)) {
                    $image_arr[] = $file->baseName . '.' . $file->extension;
                }
            }
            return $image_arr;
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