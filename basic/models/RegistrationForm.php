<?php
namespace app\models;

use yii\base\Model;
use app\models\User;
use app\models\City;
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
    public $city;
    public $state;
    public $access;
 
    public function rules()
    {
        return [
            ['password','compare'],
            [['username', 'password', 'password_repeat', 'email', 'organization', 'city', 'state', 'access'], 'required'],
            ['email', 'email'],
            [['username', 'email', 'password', 'password_repeat', 'organization', 'city'], 'filter', 'filter' => 'trim',],
        ];
    }
}
