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
            $numCounties = count($counties);

			$model = new IndustryForm();
			$model->load(Yii::$app->request->post());	
        		
			$dataProvider = $this->filter($counties,$model->field);

            $allIndrLine = [['Date', 'All Industries']];

            $queryPast = (new \yii\db\Query())
                ->select(['*'])
                ->from('past_listings')
                ->where(['county_id' => $counties])
                ->orderBy(['date' => SORT_DESC])
                ->limit(10 * $numCounties)
                ->all();

            $lastMonthCounties = [];

            for ($i=0; $i < $numCounties; $i++) { 
                array_push($lastMonthCounties, $queryPast[(3 * $numCounties) + $i]);
            }            

            $industry = $this->countIndustry($counties);
            $lastMonthInd = $this->countLastMonthIndustry($lastMonthCounties,$numCounties);
            $monthChange = $this->countMonthChange($industry,$lastMonthInd);

            $byIndrLine = $this->countByIndrPast($queryPast, $numCounties);

			return $this->render('index', [
                'dataProvider' => $dataProvider,
                'model' => $model,
                'industry' => $industry,
                'lastMonthInd' => $lastMonthInd,
                'monthChange' => $monthChange,
                'byIndrLine' => $byIndrLine,
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
        $query = (new \yii\db\Query())
        ->select(['job_field_id'])
        ->from('job')
        ->where(['county_id' => $counties])
        ->all();

        $query = ArrayHelper::getColumn($query, 'job_field_id');
        $query = array_count_values($query);

        $indTotal = $query[1] + $query[2] + $query[3] +
            $query[4] + $query[5];

        $industry = [
            'edu' => [
                'num' => $query[1],
                'perc' => (($query[1]/$indTotal) * 100)],
            'health' => [
                'num' => $query[2],
                'perc' => (($query[2]/$indTotal) * 100)],
            'agr' => [
                'num' => $query[3],
                'perc' => (($query[3]/$indTotal) * 100)],
            'eng' => [
                'num' => $query[4],
                'perc' => (($query[4]/$indTotal) * 100)],
            'bus' => [
                'num' => $query[5],
                'perc' => (($query[5]/$indTotal) * 100)],
        ];

        return $industry;
    }

    public function countLastMonthIndustry($counties,$numCounties)
    {
        $lastMonth = [(int)$counties[0]['num_edu'],(int)$counties[0]['num_health'],
                      (int)$counties[0]['num_agr'],(int)$counties[0]['num_eng'],
                      (int)$counties[0]['num_bus']];

        for($i = 1; $i < $numCounties; $i++){
            $lastMonth[0] += (int)$counties[$i]['num_edu'];
            $lastMonth[1] += (int)$counties[$i]['num_health'];
            $lastMonth[2] += (int)$counties[$i]['num_agr'];
            $lastMonth[3] += (int)$counties[$i]['num_eng'];
            $lastMonth[4] += (int)$counties[$i]['num_bus'];
        }

        $indTotal = $lastMonth[0] + $lastMonth[1] + $lastMonth[2] +
                    $lastMonth[3] + $lastMonth[4];

        $lastMonthIndustry = [
            'edu' => [
                'num' => $lastMonth[0],
                'perc' => (($lastMonth[0]/$indTotal) * 100)],
            'health' => [
                'num' => $lastMonth[1],
                'perc' => (($lastMonth[1]/$indTotal) * 100)],
            'agr' => [
                'num' => $lastMonth[2],
                'perc' => (($lastMonth[2]/$indTotal) * 100)],
            'eng' => [
                'num' => $lastMonth[3],
                'perc' => (($lastMonth[3]/$indTotal) * 100)],
            'bus' => [
                'num' => $lastMonth[4],
                'perc' => (($lastMonth[4]/$indTotal) * 100)],
        ];

        return $lastMonthIndustry;
    }

    public function countMonthChange($industry,$lastMonthIndustry)
    {

        $monthChange = [
            'edu' => [
                'num' => $industry['edu']['num']-$lastMonthIndustry['edu']['num'],
                'perc' => $industry['edu']['perc']-$lastMonthIndustry['edu']['perc']],
            'health' => [
                'num' => $industry['health']['num']-$lastMonthIndustry['health']['num'],
                'perc' => $industry['health']['perc']-$lastMonthIndustry['health']['perc']],
            'agr' => [
                'num' => $industry['agr']['num']-$lastMonthIndustry['agr']['num'],
                'perc' => $industry['agr']['perc']-$lastMonthIndustry['agr']['perc']],
            'eng' => [
                'num' => $industry['eng']['num']-$lastMonthIndustry['eng']['num'],
                'perc' => $industry['eng']['perc']-$lastMonthIndustry['eng']['perc']],
            'bus' => [
                'num' => $industry['bus']['num']-$lastMonthIndustry['bus']['num'],
                'perc' => $industry['bus']['perc']-$lastMonthIndustry['bus']['perc']],
        ];

        return $monthChange;
    }

    public function countAllIndrPast($queryPast)
    {   
        $allPast = array();

        return $allPast;
    }

    public function countByIndrPast($queryPast,$numCounties)
    {
        $dataArray = array();

        //Loop that creates a single row for each date in $dataArray
        for ($i=0; $i < 10; $i++) { 
            //Keeps track of place in $queryPast
            $n = $numCounties * $i;

            $day = substr($queryPast[$n]['date'],-2);
            $month = substr($queryPast[$n]['date'],-5,2);
            $date = $month.'/'.$day;

            $temp = [
                $date,(int)$queryPast[$n]['num_edu'],
                (int)$queryPast[$n]['num_health'],(int)$queryPast[$n]['num_agr'],
                (int)$queryPast[$n]['num_eng'],(int)$queryPast[$n]['num_bus']
            ];

            

            //Loop that adds data from rows in $queryPast to the row in $dataArray
            //which corresponds to their date
            for($j=1; $j < $numCounties; $j++){
                //Keeps track of place in $queryPast
                $k = $n + $j;

                $temp[1] += (int)$queryPast[$k]['num_edu'];
                $temp[2] += (int)$queryPast[$k]['num_health'];
                $temp[3] += (int)$queryPast[$k]['num_agr'];
                $temp[4] += (int)$queryPast[$k]['num_eng'];
                $temp[5] += (int)$queryPast[$k]['num_bus'];
            }

            array_unshift($dataArray,$temp);
        }

        $header = array('Date', 'Edu', 'Health/Med', 'Agric', 
                                'Engr/Manu/Tech','Business');
        array_unshift($dataArray, $header);

        return $dataArray;
    }
}

?>