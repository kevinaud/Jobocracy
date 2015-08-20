<?php

namespace app\models;

use Yii;
use yii\base\Model;

class IndustryForm extends \yii\base\Model
{
    public $field;

    public function rules()
    {
        return [
            [['field'],'integer']
        ];
    }
}