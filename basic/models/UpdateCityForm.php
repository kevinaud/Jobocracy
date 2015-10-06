<?php
/**
 * Filename: UpdateCityForm.php
 * Author: Kevin Aud
 * Dates Modified
 * 9/21/2015 - File Created
 *
 * UpdateCityForm is the model behind the city form on 
 * profile/update-info.php
 */
namespace app\models;

use Yii;
use yii\base\Model;

class UpdateCityForm extends Model
{
    public $city;
    public $city_repeat;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            ['city', 'compare'],

            ['city_repeat','required', 'message' => 'New City cannot be Blank.'],
            ['city','required', 'message' => 'Confirm New City cannot be Blank.'],
            
            [
               ['city', 'city_repeat'],
                'filter',
                'filter' => 'trim'
            ]
        ];
    }
}