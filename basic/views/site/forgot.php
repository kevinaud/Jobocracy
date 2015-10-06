<?php
/**
 * Filename: forgot.php
 * Author: Kevin Aud
 * Dates Modified:
 * 9/19/2015 - File Created
 *
 * forgot is a view for the site controller. It is what a
 * user is taken to when they click 'Forgot Password?' on the login
 * page. The forgot password page asks the user to enter their email
 * address so that we can send a password recovery email to them.
 */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\web\Session;
use app\assets\AppAsset;

echo '<div class="row">';

if($session->hasFlash('forgot'))
{
	echo '<div class="flash-success">';
	echo 	'<h2 class="text-center">'.$session->getFlash('forgot').'</h2>';
	echo '</div>';
}
else
{
?>

<div class="row">
	<div class="col-xs-12">
		<h2 class="text-center forgot-title">Please enter the email address associated
		with your account.</h3>
	</div>
</div>
<div class="row">
<?php

	$form = ActiveForm::begin([
		'id' => 'forgot-form',
		'options' => ['class' => 'form-horizontal'],
		'validateOnSubmit' => true,
		'encodeErrorSummary' => true,
		'fieldConfig' => [
			'template' => "{label}\n
                           <div class=\"col-lg-3\">{input}</div>\n
                           <div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
		]
	]);

	?>
	<div class="form-group field-forgotform-email required">
		<label class="col-lg-3 control-label"
			   for="forgotform[email]">Email</label>
		<div class="col-lg-6">
			<input id="forgotform-email" 
			       class="form-control" type="text"
			       name="ForgotForm[email]">
		</div>
	    <div class="col-lg-3">
			<p class="help-block help-block-error"></p>
		</div>
	<?php

	echo '<div class="form-group">';
    echo    '<div class="col-lg-9">';
    echo    '<br>';
    echo        Html::submitButton('Submit', ['class' => 'btn btn-primary 
    												      forgot-submit pull-right',
    										 'name' => 'forgot-button']);
    echo    '</div>';
    echo '</div>';

    ActiveForm::end();
}

echo '</div>';
?>
</div>