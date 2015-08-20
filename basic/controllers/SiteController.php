<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\EntryForm;
use app\models\RegistrationForm;
use app\models\User;
use app\models\City;
use app\models\State;
use app\models\County;
use app\models\Access;
use app\models\ChangePassword;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin()
    {
        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionRegister()
    {
        //check if the user is already logged in
        //if so, do nothing and return them to the home screen
        if(!\Yii::$app->user->isGuest)
        {
            return $this->goHome();
        }

        //loads model and queries the required data
        $model = new RegistrationForm();
        $stateList = State::find()
            ->all();
        $countyList = County::find()
            ->orderBy('name')
            ->all();

        //if the user has made a 'post' request AND registration form model
        //is able to succesfully register the user based on the inputted information 
        if($model->load(Yii::$app->request->post()))
        {
            $model->password = Yii::$app->getSecurity()->generatePasswordHash($model->password);

            //Creates a new row in the user table
            $post = Yii::$app->db->createCommand()->insert('user',[
                    'username' => $model->username,
                    'password_hash' => $model->password,
                    'email' => $model->email,
                    'organization' => ucwords($model->organization),
                    'city' => ucwords($model->city),
                    'state' => $model->state,
                ])->execute();

            //retrieves the user id for the newly created user
            $user= (new \yii\db\Query())
                ->select('id')
                ->from('user')
                ->where(['username' => $model->username])
                ->one();

            //selects the integer for id from the array that
            //was returned
            $user_id = $user['id'];

            FOREACH($model->access as $county => $id)
            {
                $post = Yii::$app->db->createCommand()->insert('access',[
                    'county_id' => $id,
                    'user_id' => $user_id,
                ])->execute();
            }

            //registration was successful, go back to the home screen
            return $this->render('registration-confirm');
        } else
        {
            //The user has not yet been taken to the registration form so
            //render the registration view and pass in the RegistrationForm
            //model that is stored in $model
            return $this->render('register', [
                'model' => $model,
                'stateList' => $stateList,
                'countyList' => $countyList,
            ]);
        }
    }

    public function actionViewProfile()
    {   
        $model = new ChangePassword();

        if($model->load(Yii::$app->request->post()))
        {
            $model->password_hash = Yii::$app->getSecurity()->generatePasswordHash($model->newPassword);

            Yii::$app->user->identity->setPassword($model->password_hash);

            return $this->render('view-profile',[
                'model' => $model,
                'tagline' => 'Password Succesfully Changed',
            ]);
        }
        else
        {
            return $this->render('view-profile',[
                'model' => $model,
                'tagline' => 'View Profile',
            ]);
        }
    }
    

}
