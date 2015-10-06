<?php
/**
 * Filename: UpdateEmailForm.php
 * Author: Kevin Aud
 * Dates Modified
 * 9/21/2015 - File Created
 *
 * UpdateEmailForm is the model behind the email form on 
 * profile/update-info.php
 */
namespace app\models;

use Yii;
use yii\base\Model;

class UpdateEmailForm extends Model
{
    public $email;
    public $email_repeat;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            ['email', 'compare'],

            ['email_repeat', 'email', 'message' => 'Not a valid email address'],

            ['email_repeat','required', 'message' => 'New Email cannot be Blank.'],
            ['email','required', 'message' => 'Confirm New Email cannot be Blank.'],
            
            [
               ['email', 'email_repeat'],
                'filter',
                'filter' => 'trim'
            ],

            ['email_repeat', 'validateEmail'],
        ];
    }

    public function validateEmail($attribute, $params)
    {
        $count = (new \yii\db\Query())
                ->from('user')
                ->where(['email' => $this->email])
                ->count();

        if ((int)$count != 0) {
            $this->addError($attribute, 'Email is already taken.');
        }
    }
}