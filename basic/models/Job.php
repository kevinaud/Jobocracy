<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "job".
 *
 * @property integer $id
 * @property integer $job_field_id
 * @property string $title
 * @property string $company
 * @property integer $city_id
 * @property integer $state_id
 * @property string $phone_number
 * @property string $date_posted
 * @property string $url
 *
 * @property JobField $jobField
 * @property City $city
 * @property State $state
 * @property County $county
 */
class Job extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'job';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['job_field_id', 'city_id', 'state_id'], 'required'],
            [['job_field_id', 'city_id', 'state_id'], 'integer'],
            [['date_posted'], 'safe'],
            [['title'], 'string', 'max' => 100],
            [['company'], 'string', 'max' => 50],
            [['phone_number'], 'string', 'max' => 10],
            [['url'], 'string', 'max' => 150]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'job_field_id' => 'Job Field ID',
            'title' => 'Title',
            'company' => 'Company',
            'city_id' => 'City ID',
            'state_id' => 'State ID',
            'phone_number' => 'Phone Number',
            'date_posted' => 'Date Posted',
            'url' => 'Url',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJobField()
    {
        return $this->hasOne(JobField::className(), ['id' => 'job_field_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::className(), ['id' => 'city_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCounty()
    {
        return $this->hasOne(County::className(), ['id' => 'county_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getState()
    {
        return $this->hasOne(State::className(), ['id' => 'state_id']);
    }
}
