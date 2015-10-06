<?php
/**
 * Filename: UpdateOrgForm.php
 * Author: Kevin Aud
 * Dates Modified
 * 9/21/2015 - File Created
 *
 * UpdateOrgForm is the model behind the Organization form on 
 * profile/update-info.php
 */
namespace app\models;

use Yii;
use yii\base\Model;

class UpdateOrgForm extends Model
{
    public $organization;
    public $organization_repeat;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            ['organization', 'compare'],

            ['organization_repeat','required', 'message' => 'New Organization cannot be Blank.'],
            ['organization','required', 'message' => 'Confirm New Organization cannot be Blank.'],
            
            [
               ['organization', 'organization_repeat'],
                'filter',
                'filter' => 'trim'
            ]
        ];
    }
}