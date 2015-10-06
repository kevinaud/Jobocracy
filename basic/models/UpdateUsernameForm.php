<?php
/**
 * Filename: UpdateUsernameForm.php
 * Author: Kevin Aud
 * Dates Modified
 * 9/21/2015 - File Created
 *
 * UpdateUsernameForm is the model behind the username form on 
 * profile/update-info.php
 */
namespace app\models;

use Yii;
use yii\base\Model;

class UpdateUsernameForm extends Model
{
    public $username;
    public $username_repeat;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            ['username', 'compare'],

            ['username_repeat','required', 'message' => 'New Username cannot be Blank.'],
            ['username','required', 'message' => 'Confirm New Username cannot be Blank.'],
            
            [
               ['username', 'username_repeat'],
                'filter',
                'filter' => 'trim'
            ],

            ['username_repeat', 'validateUsername'],
        ];
    }

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
}