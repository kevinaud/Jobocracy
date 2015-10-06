<?php
/**
 * Filename: update-region.php
 * Author: Kevin Aud
 * Dates Modified:
 * 9/22/2015 - 
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use app\assets\AppAsset;
use dosamigos\multiselect\MultiSelect;

?>

<div class="row">
	<div class="col-xs-11 update-region-title">
		<h2 class="text-center">Update Region</h2>
		<h3 class="text-center"> <?= $subHead ?> </h3>
	</div>
</div>
<div class="row">
	<?php 
    $form = ActiveForm::begin([
        'id'                 => 'update-region-form',
        'options'            => ['class' => 'form-horizontal',],
        'fieldConfig'        => [
            'template'     => "{label}\n
                                <div class=\"col-xs-6\">{input}</div>\n
                                <div class=\"col-xs-3\">{error}</div>",
            'labelOptions' => ['class' => 'col-xs-3 control-label'],
        ],
    ]) 
    ?>

    <!-- Begin region selection dropdowns -->
    <div class="col-xs-11">
    	<?php

        echo "<div class=\"form-group field-update-region-form-access required\">";
        echo '<div class="col-xs-3 region-list">';

        FOREACH($stateList as $state){

        	$inState = array();
        	FOREACH($countyList as $county){
                if($county->state_id == $state->id){
                    $inState = $inState + [$county->id => $county->name];
                }
            }

            echo "<label class=\"col-xs-6 control-label text-center\">".$state->name."</label>";
            echo "<div class=\"col-xs-6\">";

        	echo MultiSelect::widget([
                'id'      => $state->code,
                'options' => [
                    'multiple' => "multiple",
                    'class'    => "form-control"
                ],
				'name'    => 'UpdateRegionForm[access][]',
				'data'    => $inState,
				'value'   => $access,
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

            if ($state->id == 13 || $state->id == 26 || $state->id == 39) {
            	echo '</div>';
                echo '<div class="col-xs-3 region-list">';
            }
        }

        echo "</div>";

        ?>
    </div>
</div>
<div class="row">
    <div class="form-group">
    <div class="col-xs-11">
        <?= Html::submitButton('Update', [
            'class' => 'pull-right btn btn-primary update-region-submit',
            'name'  => 'update-region-button']) ?>
        <?php ActiveForm::end() ?>
    </div>
    </div>
</div>