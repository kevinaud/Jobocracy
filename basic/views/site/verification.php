<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>

<div class="row">
    <div class="col-xs-12">
        <h2 class="text-center forgot-title">Please enter the new password you
        would like to use for your account.</h2>
    </div>
</div>

<?php
	$form = ActiveForm::begin([
		'id' => 'reset-form',
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

	echo $form->field($model, 'password_repeat')
    		->passwordInput()->label('Password');
    echo $form->field($model, 'password')
    		->passwordInput()->label('Confirm Password');

	echo '<input name="ResetForm[token]" type="hidden" value="'.
		 $identity->token.'">';

	echo '<div class="form-group">';
    echo    '<div class="col-lg-4">';
    echo    '<br>';
    echo        Html::submitButton('Submit', ['class' => 'btn btn-primary 
    												      reset-submit pull-right',
    										 'name' => 'reset-button']);
    echo    '</div>';
    echo '</div>';

    ActiveForm::end();
?>