<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use app\assets\AppAsset;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\RegistrationForm */

$this->title = 'Register';
?>
<div class="site-register">
	<h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to register:</p>


    <?php $form = ActiveForm::begin([
    	'id' => 'registration-form',
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>

    <!--Form Fields-->
    <?= $form->field($model, 'email') ?>
    <?= $form->field($model, 'username') ?>
    <?= $form->field($model, 'password_repeat')->passwordInput()->label('Password') ?>
   	<?= $form->field($model, 'password')->passwordInput()->label('Confirm Password') ?>
   	<?= $form->field($model, 'organization') ?>
   	<?= $form->field($model, 'city') ?>
   	<?= $form->field($model, 'state')->DropDownList(ArrayHelper::map($stateList, 'code', 'name')) ?>
    
   	<h3>Select all regions whose workforce your organization is interested in.<h3>
   	<h4>You can select individual counties within a state, or you select all counties
    within a state.</h4>

    <script type="text/javascript">

      <?php

        FOREACH($stateList as $state)
        {
          echo "
          $(document).ready(function() {
              $('#"; 
          echo $state->code;
          echo "').multiselect({
                  includeSelectAllOption: true,
                  selectAllNumber: false,
                  maxHeight: 300,
                  numberDisplayed: 1,
                  selectAllText: 'Select All Counties',
                  nSelectedText: 'Counties Selected',
                  nonSelectedText: 'None Selected'
              });
          });
          ";
        }

      ?>
      //END FOR EACH STATE
      </script>

      <!--FOR EACH STATE-->

    <?php

        echo "<div class=\"form-group field-registrationform-access required\">";

        FOREACH($stateList as $state)
        {
          echo "  <label class=\"col-sm-2 control-label\">";
          echo $state->name;
          echo "</label>";
          echo "  <div class=\"col-sm-10\">";
          echo "    <select id=\"";
          echo $state->code;
          echo "\" class=\"form-control\" name=\"RegistrationForm[access][]\" multiple=\"multiple\">";
                  FOREACH($countyList as $county)
                  {
                    if($county->state_id === $state->id)
                    {
                      echo "          <option value=\"";
                      echo $county->id;
                      echo "\">";
                      echo $county->name;
                      echo "</option>";
                    }
                  }
          echo "    </select>";
          echo "  </div>";
        }
        echo "</div>";
        
    ?>
      <!--END FOR EACH STATE-->


   	<div class="form-group">
        <div class="col-lg-offset-1 col-lg-11">
            <?= Html::submitButton('Register', ['class' => 'btn btn-primary', 'name' => 'registration-button']) ?>
        </div>
    </div>

    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>

    <?php ActiveForm::end(); ?>

</div>

<!--When the user hits submit all of the input will be placed into the variables in
   	    the RegistrationForm model and the page will be reloaded, therefore calling the 'register' 
   	    action once more. Only this time, $model will call it's $model->register() method, using
   	    the data that was submitted by the user-->