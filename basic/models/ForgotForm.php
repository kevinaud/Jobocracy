<?php
/**
 * Filename: ForgotForm.php
 * Author: Kevin Aud
 * Dates Modified
 * 9/19/2015 - File Created
 *
 * ForgotForm is the model behind forgot-form on forgot.php
 */
namespace app\models;

use Yii;
use yii\base\Model;

class ForgotForm extends Model
{
    public $email;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            ['email','required'],
            ['email','email'],
            ['email','validateEmail'],
        ];
    }

/**
 * validateEmail
 *
 * Checks if there are any accounts registered under the given email address.
 * Counts all rows in the user table that have an email equal to the email
 * entered in to form and adds an error if the returned count is equal to 0.
 * 
 * @param  $attribute
 * @param  $params
 * @return none        
     */
    public function validateEmail($attribute, $params)
    {
        $count = (new \yii\db\Query())
                ->from('user')
                ->where(['email' => $this->email])
                ->count();

        if ((int)$count === 0) {
            $this->addError($attribute, 'There is not an account registered under
                that email address.');
        }
    }
}