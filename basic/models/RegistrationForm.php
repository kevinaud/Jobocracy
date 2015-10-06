<?php
/**
* Filename: RegistrationForm.php
* Author: Kevin Aud
* Dates Modified:
* 9/18/2015 - Added validateEmail and validateUsername functions for back
* end input validation. 
* 
* Used to hold the information that a user inputs on register.php a view
* of the site controller. When the user hits submit, all of the information
* from each field will be stored in its corresponding RegistrationForm
* variable and actionRegister will be recalled. Some of the data will be 
* reformatted, such as $password which will be hashed, and then this model
* will be used to create a new row in the user table. 
*/
namespace app\models;

use yii\base\Model;
use app\models\User;
use app\models\County;
use app\assets\AppAsset;

/**
 * RegistrationForm is the model behind the registration form.
 */
class RegistrationForm extends Model
{
    public $username;
    public $password;
    public $password_repeat;
    public $email;
    public $organization;
    public $county;
    public $state;
    /**
     * $access is used to hold an array of county ids corresponding to any 
     * counties selected by the user in the 'select region' section of the 
     * registration page
     * @var int array
     */
    public $access;
 
    /**
     * Describes form validation rules for RegistrationForm
     * @return {Multi-dimensional Array}, returns rule set
     */
    public function rules()
    {
        return [
            /* The attributes $password and $password_repeat must match */
            ['password','compare'],

            /* All listed attributes must not be Null */
            [
                ['username', 
                 'email', 
                 'organization', 
                 'county', 
                 'state'], 

                'required'
            ],
            ['password_repeat','required', 'message' => 'Password cannot be Blank.'],
            ['password','required', 'message' => 'Confirm Password cannot be Blank.'],
            ['access','required', 'message' => 'You must select your Region.'],
            /* The info entered for email must be in the format of an email */
            ['email', 'email'],
            /* Trim whitespace from around all listed attributes */
            [
                ['username', 
                 'email', 
                 'password', 
                 'password_repeat', 
                 'organization', 
                 'county'], 

                'filter', 'filter' => 'trim',
            ],

            ['username', 'validateUsername'],
            ['email', 'validateEmail']
        ];
    }

    /**
     * validateUsername
     * 
     * Checks if the entered username is already taken. Counts all rows in the
     * user table that have a username equal to the username entered in the
     * form and adds an error if the returned count is not equal to 0.
     * 
     * @param  $attribute
     * @param  $params
     * @return none
     */
    public function validateUsername($attribute, $params)
    {
        $count = (new \yii\db\Query())
                ->from('user')
                ->where(['username' => $this->username])
                ->count();

        if ((int)$count != 0) {
            $this->addError($attribute, 'Username is already taken.');
        }
    }

    /**
     * validateEmail
     * 
     * Checks if the entered username is already taken. Counts all rows in the
     * user table that have an email equal to the email entered in to form and
     * adds an error if the returned count is not equal to 0
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

        if ((int)$count != 0) {
            $this->addError($attribute, 'Email is already taken.');
        }
    }
}
