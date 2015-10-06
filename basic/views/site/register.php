<?php
/**
* Filename: register.php
* Author: Kevin Aud
* Dates Modified:
* 9/19/2015 - Added error summary above form 
* 
*   register.php is a view of the Site Controller that is rendered
* by actionRegister(); The form is generated with the active form
* widget. The county selection dropdowns are generated with the
* multiselect widget. The form is connected to the RegistrationForm 
* model.
*
*   When the user hits submit all of the input will be placed into the 
* variables in the RegistrationForm model and the page will be reloaded, 
* therefore calling the 'register' action once more. Only this time, 
* $model will call it's $model->register() method, using the data that 
* was submitted by the user.
*/
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use app\assets\AppAsset;
use dosamigos\multiselect\MultiSelect;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\RegistrationForm */

$this->title = 'Register';
?>
<div class="site-register">
    <div class="row">
        <div class="col-xs-12">
            <!-- Page Header -->
            <h1 class="text-center"><?= Html::encode($this->title) ?></h1>
            <p class="text-center">Please fill out the following fields to register:</p>
        </div>
    </div>
    <div class="row">
        <!-- text input form column -->
        <div class="col-xs-8 col-xs-offset-2">
            <div class="row">
                    <?php 
                    $form = ActiveForm::begin([
                        'id'                 => 'registration-form',
                        'options'            => ['class' => 'form-horizontal',],
                        'validateOnChange'   => true,
                        'encodeErrorSummary' => true,
                        'fieldConfig'        => [
                            'template'     => "{label}\n
                                                <div class=\"col-xs-6\">{input}</div>\n
                                                <div class=\"col-xs-3\">{error}</div>",
                            'labelOptions' => ['class' => 'col-xs-3 control-label'],
                        ],
                    ]) 
                    ?>
                    <?= $form->errorSummary($model) ?>
                    <?= $form->field($model, 'email') ?>
                    <?= $form->field($model, 'username') ?>
                    <?= $form->field($model, 'password_repeat')
                    ->passwordInput()->label('Password') ?>
                    <?= $form->field($model, 'password')
                    ->passwordInput()->label('Confirm Password') ?>
                    <?= $form->field($model, 'organization') ?>
                    <?= $form->field($model, 'county') ?>
                    <?= $form->field($model, 'state')
                    ->DropDownList(ArrayHelper::map($stateList, 'code', 'name')) ?>
            </div>
        </div>
    </div>
        <!-- Region Selection Column -->
            <div class="row">
                <div class="col-xs-12">
                    <!-- Region Selection Header -->
                    <h3 class="text-center">Select all regions whose workforce 
                    your organization is interested in.<h3>
                    <h4 class="text-center">You can select individual counties
                     within a state, or you can select all counties within a state.</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-11">
                
                <!--FOR EACH STATE-->
    <?php

        echo "<div class=\"form-group field-registrationform-access required\">";
        echo '<div class="col-xs-3 region-list">';

        FOREACH($stateList as $state)
        {

            $inState = array();
            FOREACH($countyList as $county){
                if($county->state_id == $state->id){
                    $inState = $inState + [$county->id => $county->name];
                }
            }

            echo "<label class=\"col-xs-6 control-label\">".$state->name."</label>";
            echo "<div class=\"col-xs-6\">";
          
            echo MultiSelect::widget([
                'id' => $state->code,
                'options' => [
                    'multiple' => "multiple",
                    'class'    => "form-control"
                ],
                'name' => 'RegistrationForm[access][]',
                'data' => $inState,
                "clientOptions" => [
                    "includeSelectAllOption" => true,
                    'numberDisplayed'        => 1,
                    'selectAllNumber'        => false,
                    'maxHeight'              => 300,
                    'selectAllText'          => 'Select All Counties',
                    'nSelectedText'          => 'Counties Selected',
                    'nonSelectedText'        => 'None Selected'
                ], 
            ]);
            echo "</div>";
            if($state->id == 13 || $state->id == 26 || $state->id == 39){
                echo '</div>';
                echo '<div class="col-xs-3 region-list">';
            }
        };
        
        echo "</div>";
    ?>
      <!--END FOR EACH STATE-->
            </div>
        </div>
    </div>
    <div class="row">
        <div class="form-group">
        <div class="col-xs-11">
            <?= Html::submitButton('Register', [
                'class' => 'pull-right btn btn-primary register-submit',
                'name'  => 'registration-button']) ?>
            <?php ActiveForm::end() ?>
        </div>
        </div>
    </div>
</div>