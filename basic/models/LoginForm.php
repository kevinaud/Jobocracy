<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\User;

/**
 * LoginForm is the model behind the login form.
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $password_hash;

    private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {

            $identity = User::findOne(
                ['username' => $this->username]
            );

            if($identity){
                if (!Yii::$app->getSecurity()
                    ->validatePassword($this->password,$identity->password_hash))
                {
                    $identity = NULL;
                }
                if (!$identity) {
                    $this->addError($attribute, 'Incorrect Password.');

                }
            } else
            {
                $this->addError($attribute, '');
                $this->addError('username', 'Username not found.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser());
        } else {
            return false;
        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findOne(
                ['username' => $this->username],
                ['password_hash' => $this->password_hash]
            );
        }

        return $this->_user;
    }
}
