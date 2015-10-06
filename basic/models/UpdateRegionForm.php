<?php
/**
 * Filename: UpdateRegionForm.php
 * Author: Kevin Aud
 * Dates Modified
 * 9/21/2015 - File Created
 *
 * UpdateRegionForm is the model behind the update region form on 
 * profile/update-region.php
 */
namespace app\models;

use Yii;
use yii\base\Model;

class UpdateRegionForm extends Model
{
    public $access;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            ['access','required', 'message' => 'You must select your Region.'],
        ];
    }
}