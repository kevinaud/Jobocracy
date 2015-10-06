<?php
/**
 * Filename: SiteController.php
 * Author: Kevin Aud
 * Dates Modified:
 * 9/19/2015 - Changed actionRegister so that when it is reloaded after
 *     form submission, it calls model->validate() before creating a new 
 *     user
 *
 * The Site Controller contains the action for loading the home page, 
 * login page, and registration page. It also contains all of the logic
 * behind user registration. 
 */
namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Session;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\EntryForm;
use app\models\RegistrationForm;
use app\models\ForgotForm;
use app\models\ResetForm;
use app\models\User;
use app\models\City;
use app\models\State;
use app\models\County;
use app\models\Access;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only'  => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow'   => true,
                        'roles'   => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class'   => VerbFilter::className(),
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
                'class'           => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * actionIndex
     *
     * Renders the home page
     * 
     * @return views/site/index
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * actionLogin
     *
     * Renders the login page if no data has been loaded into the model.
     * Otherwise it attemps to log a user in and takes them back to the home
     * screen if that is successful.
     */
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

    /**
     * actionLogout
     *
     * The action that is called when the logout button is clicked. The logout
     * action doesn't actually render a view, it just calls user->logout and
     * then takes you back to the homescreen.
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * actionRegister
     *
     * the Register action contains most of the logic behind user registration.
     * When it is called it checks to see if any data can be loaded into the
     * RegistrationForm model. If not then that means the user has not yet been
     * taken to the registration page, so it collects the data need to render
     * the registration page/form (all of the states and counties needed to fill
     * in the dropdowns, etc.) and renders view/site/registration. If however
     * data is able to be loaded into the RegistrationForm model, then that
     * means that the user has already submitted a filled out form, so it calls
     * model->validate() to make sure that all of the input is good and to make
     * sure that the entered username and email address have not already been
     * taken. If that does not return any errors then newUser(), a member
     * function of SiteController, is called and the RegistrationForm model is
     * passed in. After that, registration-confirm is rendered.
     */
    public function actionRegister()
    {
        /**
        * check if the user is already logged in
        * if so, do nothing and return them to the home screen
        */
        if(!\Yii::$app->user->isGuest)
        {
            return $this->goHome();
        }

        /** 
        * loads model that will store all data entered into the ActiveForm
        * on register.php and contains all front-end validation rules
        */
        $model = new RegistrationForm();

        /* Used to populate 'select state' dropdown and 'select region' section */
        $stateList = State::find()
            ->all();
        /* Used to populate the 'select region' multiselects */
        $countyList = County::find()
            ->orderBy('name')
            ->all();

        /**
        * if the user has made a 'post' request AND registration form model
        * is able to succesfully register the user based on the inputted information 
        */
        if($model->load(Yii::$app->request->post()) && $model->validate())
        {
            /* Calls member function newUser() and passes in a populated model */
            $this->newUser($model);

            /* registration was successful, go back to registration-confirm view */
            return $this->render('registration-confirm', [
                'model' => $model,
            ]);
        } else
        {
            /**
            * The user has not yet been taken to the registration form so
            * render the registration view and pass in an empty RegistrationForm
            * model that is stored in $model
            */
            return $this->render('register', [
                'model' => $model,
                'stateList' => $stateList,
                'countyList' => $countyList,
            ]);
        }
    }
    
    /**
     * newUser
     *
     * This function takes a RegistrationForm model as a parameter and uses the
     * values stored in it to insert a new row into the 'user' database table.
     * It also parses the $model->access array and uses it to insert the
     * necesarry rows into the 'access' database table. It is called from
     * actionRegister.
     * 
     * @param  [RegistrationForm] $model
     */
    public function newUser($model)
    {
        $model->password = Yii::$app->getSecurity()
                ->generatePasswordHash($model->password);

        //Creates a new row in the user table
        $post = Yii::$app->db->createCommand()->insert('user',[
                'username'      => $model->username,
                'password_hash' => $model->password,
                'email'         => $model->email,
                'organization'  => ucwords($model->organization),
                'city'          => ucwords($model->county),
                'state'         => $model->state,
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
            if($id != "multiselect-all"){
                $post = Yii::$app->db->createCommand()->insert('access',[
                    'county_id' => $id,
                    'user_id' => $user_id,
                ])->execute();
            }
        }
    }

    /**
     * [actionForgot description]
     * @return [type] [description]
     */
    public function actionForgot()
    {
        $model = new ForgotForm();

        $session = new Session;

        if($model->load(Yii::$app->request->post()) && $model->validate())
        {
            $getEmail = $model->email;
            $getIdentity = User::find()->where(['email' => $getEmail])->one();

            $getToken = rand(0,99999);
            $getTime = date("H:i:s");
            $calcToken = md5($getToken.$getTime);
            $getIdentity->token = $calcToken;

            $getEmail = "kevinaud@gmail.com";

            $emailAdmin = "kaud@Jobocracy.org";

            $senderName = "Jobocracy";
            $senderName = '=?UTF-8?B?'.base64_encode($senderName).'?=';

            $subject = "Reset Password";
            $subject = '=?UTF-8?B?'.base64_encode($subject).'?=';

            $message = 'You have successfully reset your password<br>
                       <a href="localhost/application/basic/web/index.php?r=site/ver-token&token='.
                       $calcToken.'">Click Here to Reset Your Password</a>';

            $headers = "From: $senderName <{$emailAdmin}>\r\n".
                       "Reply To: {$emailAdmin}\r\n".
                       "MIME-Version: 1.0\r\n".
                       "Content-type: text/html; charset=UTF-8";
            $getIdentity->save();

            $session->setFlash('forgot', 'A link to reset your password
                has been sent to your email address.');

            mail($getEmail, $subject, $message, $headers);

            return $this->render('forgot',[
                'session' => $session
            ]);
        }
        return $this->render('forgot', [
                'model' => $model,
                'session' => $session
        ]);
    }

    /**
     * [actionVerToken description]
     * @param  [type] $token [description]
     * @return [type]        [description]
     */
    public function actionVerToken($token){
        $identity = $this->getToken($token);
        $model = new ResetForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            //if($identity->token == $model->token){
                $identity->password_hash = Yii::$app->getSecurity()
                                ->generatePasswordHash($model->password);
                $identity->token = NULL;
                $identity->save();

                return $this->render('pass-change-confirm');
            //}
        }
        return $this->render('verification', [
            'model' => $model,
            'identity' => $identity,
        ]);
    }

    /**
     * [getToken description]
     * @return [type] [description]
     */
    public function getToken($token){
        $identity = User::find()
            ->where(['token' => $token])
            ->one();
        if($identity === null){
            throw new \yii\web\HttpException(404,'The requested page
                does not exist');
        }
        return $identity;
    }
}
