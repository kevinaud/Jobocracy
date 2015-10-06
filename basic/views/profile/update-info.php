<?php
/**
 * Filename: update-info.php
 * Author: Kevin Aud
 * Dates Modified:
 * 9/21/2015 - File created
 *
 * update-info is a view of the Profile controller and it is accessed 
 * by a link on the 'Profile Page.' It consists of 5 seperate forms, each 
 * with their own submit button, for editing the username, password, email, 
 * organization, city, or state, that is associated with a given user.
 */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this 		yii\web\View 				  */
/* @var $form 		yii\bootstrap\ActiveForm 	  */
/* @var $username 	app\models\UpdateUsernameForm */
/* @var $password 	app\models\UpdatePasswordForm */
/* @var $email   	app\models\UpdateEmailForm    */
/* @var $org 		app\models\UpdateOrgForm 	  */                    
/* @var $city 		app\models\UpdateCityForm 	  */                
/* @var $state 		app\models\UpdateStateForm 	  */ 
/* @var $stateLists app\models\State              */           
?>
<?php /* Page Title */ ?>
<div class="row">
	<div class="col-xs-6 col-xs-offset-2"><h2 class="text-center">Update Info</h2></div>
</div>
<div class="row">
    <div class="col-xs-6 col-xs-offset-2">
        <h3 class="text-center"><?= $subTitle ?></h3>
    </div>
</div>
<div class="row">
	<div class="col-xs-2 col-xs-offset-2 text-center"><strong>New</strong></div>
	<div class="col-xs-2 col-xs-offset-2 text-center"><strong>Confirm</strong></div>
</div>
<!-- UPDATE USERNAME -->	
<div class="row">
	<div class="col-xs-2 text-right">
		Username
	</div>
	<?php
		$form = ActiveForm::begin([
            'id'                 => 'username-form',
            'options'            => ['class' => 'form-horizontal',],
            'validateOnChange'   => true,
            'fieldConfig'        => [
                'template'     => "<div class=\"row\">
								      <div class=\"col-xs-6\">{input}</div>
                                      <div class=\"col-xs-6\">{error}</div>
                                   </div>",
            ],
        ]);
    ?>
    <div class="col-xs-4">
		<?= $form->field($username, 'username_repeat') ?>
	</div>
	<div class="col-xs-4">
		<?= $form->field($username, 'username') ?>
	</div>

	<div class="col-xs-1">
        <?= Html::submitButton('Submit', [
            'class' => 'btn btn-primary username-submit',
            'name'  => 'username-button']) ?>
        <?php ActiveForm::end() ?>
    </div>
</div>
<!-- UPDATE PASSWORD -->
<div class="row">
	<div class="col-xs-2 text-right">
		Password
	</div>
	<?php
		$form = ActiveForm::begin([
            'id'                 => 'password-form',
            'options'            => ['class' => 'form-horizontal',],
            'validateOnChange'   => true,
            'fieldConfig'        => [
                'template'     => "<div class=\"row\">
								      <div class=\"col-xs-6\">{input}</div>
                                      <div class=\"col-xs-6\">{error}</div>
                                   </div>",
            ],
        ]);
    ?>
    <div class="col-xs-4">
		<?= $form->field($password, 'password_repeat')->passwordInput() ?>
	</div>
	<div class="col-xs-4">
		<?= $form->field($password, 'password')->passwordInput() ?>
	</div>
	<div class="col-xs-1">
        <?= Html::submitButton('Submit', [
            'class' => 'btn btn-primary password-submit',
            'name'  => 'password-button']) ?>
        <?php ActiveForm::end() ?>
    </div>
</div>
<!-- UPDATE EMAIL -->
<div class="row">
	<div class="col-xs-2 text-right">
		Email
	</div>
	<?php
		$form = ActiveForm::begin([
            'id'                 => 'email-form',
            'options'            => ['class' => 'form-horizontal',],
            'validateOnChange'   => true,
            'fieldConfig'        => [
                'template'     => "<div class=\"row\">
								      <div class=\"col-xs-6\">{input}</div>
                                      <div class=\"col-xs-6\">{error}</div>
                                   </div>",
            ],
        ]);
    ?>
    <div class="col-xs-4">
		<?= $form->field($email, 'email_repeat') ?>
	</div>
	<div class="col-xs-4">
		<?= $form->field($email, 'email') ?>
	</div>
	<div class="col-xs-1">
        <?= Html::submitButton('Submit', [
            'class' => 'btn btn-primary email-submit',
            'name'  => 'email-button']) ?>
        <?php ActiveForm::end() ?>
    </div>
</div>
<!-- UPDATE ORGANIZATION -->
<div class="row">
	<div class="col-xs-2 text-right">
		Organization
	</div>
	<?php
		$form = ActiveForm::begin([
            'id'                 => 'org-form',
            'options'            => ['class' => 'form-horizontal',],
            'validateOnChange'   => true,
            'fieldConfig'        => [
                'template'     => "<div class=\"row\">
								      <div class=\"col-xs-6\">{input}</div>
                                      <div class=\"col-xs-6\">{error}</div>
                                   </div>",
            ],
        ]);
    ?>
    <div class="col-xs-4">
		<?= $form->field($org, 'organization_repeat') ?>
	</div>
	<div class="col-xs-4">
		<?= $form->field($org, 'organization') ?>
	</div>
	<div class="col-xs-1">
        <?= Html::submitButton('Submit', [
            'class' => 'btn btn-primary org-submit',
            'name'  => 'org-button']) ?>
        <?php ActiveForm::end() ?>
    </div>
</div>
<!-- UPDATE CITY -->
<div class="row">
	<div class="col-xs-2 text-right">
		City
	</div>
	<?php
		$form = ActiveForm::begin([
            'id'                 => 'city-form',
            'options'            => ['class' => 'form-horizontal',],
            'validateOnChange'   => true,
            'fieldConfig'        => [
                'template'     => "<div class=\"row\">
								      <div class=\"col-xs-6\">{input}</div>
                                      <div class=\"col-xs-6\">{error}</div>
                                   </div>",
            ],
        ]);
    ?>
    <div class="col-xs-4">
		<?= $form->field($city, 'city_repeat') ?>
	</div>
	<div class="col-xs-4">
		<?= $form->field($city, 'city') ?>
	</div>
	<div class="col-xs-1">
        <?= Html::submitButton('Submit', [
            'class' => 'btn btn-primary city-submit',
            'name'  => 'city-button']) ?>
        <?php ActiveForm::end() ?>
    </div>
</div>
<!-- UPDATE STATE -->
<div class="row">
	<div class="col-xs-2 text-right">
		State
	</div>
    <?php
        $form = ActiveForm::begin([
            'id'                 => 'city-form',
            'options'            => ['class' => 'form-horizontal',],
            'validateOnChange'   => true,
            'fieldConfig'        => [
                'template'     => "<div class=\"row\">
                                      <div class=\"col-xs-6\">{input}</div>
                                      <div class=\"col-xs-6\">{error}</div>
                                   </div>",
            ],
        ]);
    ?>
    <div class="col-xs-4">
        <?= $form->field($state, 'state')
        ->DropDownList(ArrayHelper::map($stateList, 'code', 'name')) ?>
    </div>
    <div class="col-xs-1 col-xs-offset-4">
        <?= Html::submitButton('Submit', [
            'class' => 'btn btn-primary state-submit',
            'name'  => 'state-button']) ?>
        <?php ActiveForm::end() ?>
    </div>
</div>