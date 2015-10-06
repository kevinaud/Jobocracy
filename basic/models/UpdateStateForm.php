<?php
/**
 * Filename: UpdateStateForm.php
 * Author: Kevin Aud
 * Dates Modified
 * 9/21/2015 - File Created
 *
 * UpdateStateForm is the model behind the state form on 
 * profile/update-info.php
 */
namespace app\models;

use Yii;
use yii\base\Model;

class UpdateStateForm extends Model
{
    public $state;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            ['state', 'required'],
        ];
    }
}