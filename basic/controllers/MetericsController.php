<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\Job;
use app\models\Access;
use app\models\IndustryForm;
use yii\helpers\ArrayHelper;
use yii\data\ArrayDataProvider;

class MetericsController extends Controller
{
	public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

	public function actionIndex()
	{
		if (\Yii::$app->user->isGuest) {
			return $this->render('guest');
		} 
		else 
		{
			$access = Access::findAll([
                'user_id' => Yii::$app->user->getId(),
	        ]);

	        $counties = ArrayHelper::getColumn($access, 'county_id');

            $industry = $this->countIndustry($counties);

			$model = new IndustryForm();
			$model->load(Yii::$app->request->post());	
        		
			$dataProvider = $this->filter($counties,$model->field);

            $allIndrLine = [['Date', 'All Industries']];
            $byIndrLine = [['Date', 'Education', 'Health/Medicine', 'Agriculture', 
                            'Engineering/Manufacturing/Tech','Business']];

            $queryPast = (new \yii\db\Query())
                ->select(['*'])
                ->from('past_listings')
                ->where(['county_id' => $counties])
                ->orderBy(['date' => 'SORT_DESC'])
                ->limit(10)
                ->all();
                

            //$allIndrLine = array_merge($allIndrLine,$this->countAllIndrPast($queryPast));
            //$byIndrLine = $this->countByIndrPast($queryPast);

			return $this->render('index', [
                'dataProvider' => $dataProvider,
                'model' => $model,
                'industry' => $industry,
                //'allIndrLine' => $allIndrLine,
                //'byIndrLine' => $byIndrLine,
            ]);
        }
	}

	public function filter($counties,$field)
    {
        $query = (new \yii\db\Query())
            ->select(['company'])
            ->from('job')
            ->where(['county_id' => $counties]);

        if ($field) {
          $query->andWhere(['like', 'job_field_id', $field]);
        }

        $query = $query->all();

        $companies = ArrayHelper::getColumn($query, 'company');
        $companies = array_count_values($companies);
        $openCount = array();

        FOREACH($companies as $comp => $count)
        {
          $temp = [['company' => $comp, 'openings' => $count]];
          $openCount = array_merge($openCount,$temp);
        }

        ArrayHelper::multisort($openCount, ['openings'], [SORT_DESC]);

        $dataProvider = new ArrayDataProvider([
            'allModels' => $openCount,
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);

        return $dataProvider;
    }

    public function countIndustry($counties)
    {
        $industry = (new \yii\db\Query())
        ->select(['*'])
        ->from('job')
        ->where(['county_id' => $counties])
        ->all();

        $industry = ArrayHelper::getColumn($industry, 'job_field_id');
        $industry = array_count_values($industry);

        return $industry;
    }

    public function countAllIndrPast($queryPast)
    {   
        $allPast = array();

        return $allPast;
    }

    public function countByIndrPast($queryPast)
    {
        $byPast = array(
                array('Date', 'Education', 'Health/Medicine', 'Agriculture', 
                                'Engineering/Manufacturing/Tech','Business')
            );

        FOREACH($queryPast as $row)
        {
            $temp = [$row['date'],$row['num_edu'],$row['num_health'],
                     $row['num_agr'],$row['num_eng'],$row['num_bus']];
            $byPast = array_unshift($byPast,$temp);
        }

        return $byPast;
    }
}

?>