<?php
namespace app\models;

use Yii;
use yii\base\Model;

class ChangePassword extends Model
{
	public $newPassword;
	public $newPassword_repeat;
	public $password_hash;

	public function rules()
    {
        return [
            ['newPassword','compare'],
            [['newPassword', 'newPassword_repeat'], 'required'],
        ];
    }
}