<?php
/**
 * Filename: ResetForm.php
 * Author: Kevin Aud
 * Dates Modified
 * 9/19/2015 - File Created
 *
 * ResetForm is the model behind reset-form on verification.php
 */
namespace app\models;

use Yii;
use yii\base\Model;

class ResetForm extends Model
{
    public $password;
    public $password_repeat;
    public $token;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            ['password', 'compare'],

            ['password_repeat','required', 'message' => 'Password cannot be Blank.'],
            ['password','required', 'message' => 'Confirm Password cannot be Blank.'],
            
            [
               ['password', 'password_repeat'],
                'filter',
                'filter' => 'trim'
            ]
        ];
    }
}