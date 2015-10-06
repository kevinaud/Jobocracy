<?php
/**
 * Filename: UpdatePassForm.php
 * Author: Kevin Aud
 * Dates Modified
 * 9/21/2015 - File Created
 *
 * UpdatePassForm is the model behind the password form on 
 * profile/update-info.php
 */
namespace app\models;

use Yii;
use yii\base\Model;

class UpdatePassForm extends Model
{
    public $password;
    public $password_repeat;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            ['password', 'compare'],

            ['password_repeat','required', 'message' => 'New Password cannot be Blank.'],
            ['password','required', 'message' => 'Confirm New Password cannot be Blank.'],
            
            [
               ['password', 'password_repeat'],
                'filter',
                'filter' => 'trim'
            ]
        ];
    }
}