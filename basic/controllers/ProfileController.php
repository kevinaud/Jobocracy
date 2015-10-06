<?php
/**
 * Filename: ProfileController.php
 * Author: Kevin Aud
 * Dates Modified:
 * 9/21/2015 - added all update form models to 'use' list and 
 * loaded them into actionUpdate
 * 9/22/2015 - UpdateInfo form functionality implemented
 */
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use app\models\User;
use app\models\Access;
use app\models\ChangePassword;
use app\models\UpdateUsernameForm;
use app\models\UpdatePassForm;
use app\models\UpdateEmailForm;
use app\models\UpdateOrgForm;
use app\models\UpdateCityForm;
use app\models\UpdateStateForm;
use app\models\UpdateRegionForm;
use app\models\State;
use app\models\County;

class ProfileController extends Controller
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
        $access = Access::findAll([
            'user_id' => Yii::$app->user->getId(),
        ]);

        $counties = ArrayHelper::getColumn($access, 'county_id');

        $numOpen = (new \yii\db\Query())
                ->select(['count(*)'])
                ->from('job')
                ->where(['county_id' => $counties])
                ->all();

        $numOpen = $numOpen[0]["count(*)"];

        return $this->render('index', [
            'numOpen' => $numOpen,
            'counties' => $counties,
        ]);
    }

    public function actionUpdateInfo()
    {
        /**
        * check if the user is already logged in
        * if so, do nothing and return them to the home screen
        */
        if(\Yii::$app->user->isGuest)
        {
            return $this->goHome();
        }

        $subTitle = "";

        $identity = User::find()
            ->where(['id' => Yii::$app->user->getId()])
            ->one();

        $username = new UpdateUsernameForm();
        $password = new UpdatePassForm();
        $email    = new UpdateEmailForm();
        $org      = new UpdateOrgForm();
        $city     = new UpdateCityForm();
        $state    = new UpdateStateForm();

        $stateList = State::find()
            ->all();

        if($username->load(Yii::$app->request->post()) && $username->validate()){
            $identity->username = $username->username;
            $identity->save();
            $subTitle = "Username successfully changed.";
        }
        elseif($password->load(Yii::$app->request->post()) && $password->validate()){
            $identity->password = $password->password;
            $identity->save();
            $subTitle = "Password successfully changed.";
        }
        elseif($email->load(Yii::$app->request->post()) && $email->validate()){
            $identity->email = $email->email;
            $identity->save();
            $subTitle = "Email successfully changed.";
        }
        elseif($org->load(Yii::$app->request->post()) && $org->validate()){
            $identity->organization = $org->organization;
            $identity->save();
            $subTitle = "Organization successfully changed.";
        }
        elseif($city->load(Yii::$app->request->post()) && $city->validate()){
            $identity->city = $city->city;
            $identity->save();
            $subTitle = "City successfully changed.";
        }
        elseif($state->load(Yii::$app->request->post()) && $state->validate()){
            $identity->state = $state->state;
            $identity->save();
            $subTitle = "State successfully changed.";
        }


        return $this->render('update-info', [
            'subTitle'  => $subTitle,
            'username'  => $username,
            'password'  => $password,
            'email'     => $email,
            'org'       => $org,
            'city'      => $city,
            'state'     => $state,
            'stateList' => $stateList,
        ]);
    }

    public function actionUpdateRegion()
    {
        /**
        * check if the user is already logged in
        * if so, do nothing and return them to the home screen
        */
        if(\Yii::$app->user->isGuest)
        {
            return $this->goHome();
        }

        $model = new UpdateRegionForm();

        $stateList = State::find()
                        ->all();

        $countyList = County::find()
                        ->orderBy('name')
                        ->all();

        if($model->load(Yii::$app->request->post()))
        {
            $subHead = 'You must select a region.';
            if($model->validate()){
                $subHead = 'Region Successfully Changed';

                $post = Yii::$app->db->createCommand()->delete('access',[
                    'user_id' => Yii::$app->user->getId(),
                    ])->execute();

                FOREACH($model->access as $county => $id)
                {
                    if($id != "multiselect-all"){
                        $post = Yii::$app->db->createCommand()->insert('access',[
                            'county_id' => $id,
                            'user_id' => Yii::$app->user->getId(),
                        ])->execute();
                    }
                }
            }
            
            $access = Access::findAll([
                'user_id' => Yii::$app->user->getId(),
            ]);
            $access = ArrayHelper::getColumn($access, 'county_id');


            return $this->render('update-region', [
                'access'     => $access,
                'model'      => $model,
                'stateList'  => $stateList,
                'countyList' => $countyList,
                'subHead'    => $subHead,
            ]);
        } 
        $access = Access::findAll([
            'user_id' => Yii::$app->user->getId(),
        ]);
        $access = ArrayHelper::getColumn($access, 'county_id');


        return $this->render('update-region', [
            'access'     => $access,
            'model'      => $model,
            'stateList'  => $stateList,
            'countyList' => $countyList,
            'subHead'    => '',
        ]);
    }
}