<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Job;
use app\models\Access;
use yii\helpers\ArrayHelper;

/**
 * JobSearch represents the model behind the search form about `app\models\Job`.
 */
class JobSearch extends Job
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'job_field_id', 'city_id', 'state_id', 'county_id'], 'integer'],
            [['title', 'company', 'phone_number', 'date_posted', 'url', 'jobField.name',
              'city.name', 'state.name', 'county.name'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $access = Access::findAll([
                'user_id' => Yii::$app->user->getId(),
            ]);

        $counties = ArrayHelper::getColumn($access, 'county_id');

        $query = Job::find()
            ->where(['county.id' => $counties]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        $dataProvider->sort->attributes['jobField.name'] = [
              'asc' => ['job_field.name' => SORT_ASC],
              'desc' => ['Job_field.name' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['city.name'] = [
              'asc' => ['city.name' => SORT_ASC],
              'desc' => ['city.name' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['state.name'] = [
              'asc' => ['state.name' => SORT_ASC],
              'desc' => ['state.name' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['county.name'] = [
              'asc' => ['county.name' => SORT_ASC],
              'desc' => ['county.name' => SORT_DESC],
        ];

        $query->joinWith(['jobField']);
        $query->joinWith(['city']);
        $query->joinWith(['state']);
        $query->joinWith(['county']);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
             $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'job_field_id' => $this->job_field_id,
            'state_id' => $this->state_id,
            'date_posted' => $this->date_posted,
            'job_field.name' => $this->jobField['name'],
            'city.name' => $this->city['name'],
            'county.name' => $this->county['name'],
            'state.name' => $this->state['name'],
            
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'company', $this->company])
            ->andFilterWhere(['like', 'phone_number', $this->phone_number])
            ->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like','job_field.name',$this->getAttribute('jobField.name')])
            ->andFilterWhere(['like', 'city.name', $this->getAttribute('city.name')])
            ->andFilterWhere(['like', 'county.name', $this->getAttribute('county.name')])
            ->andFilterWhere(['like', 'state.name', $this->getAttribute('state.name')]);

        return $dataProvider;
    }

    public function attributes()
    {
        $allAttr = array_merge(parent::attributes(), ['city.name']);
        $allAttr = array_merge($allAttr, ['state.name']);
        $allAttr = array_merge($allAttr, ['jobField.name']);
        $allAttr = array_merge($allAttr, ['county.name']);

        return $allAttr;
    }
}
