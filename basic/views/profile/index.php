<?php
	use yii\helpers\Html;

	$this->title = 'View Profile';
?>

<div class="row">
	<div class="col-xs-4">
		<h2><?= Html::encode(strtoupper(Yii::$app->user->identity->organization)) ?></h2>
		<a href="/application/basic/web/index.php?r=profile%2Fupdate-info"
               class="btn btn-primary btn-sm up-info-btn">Update Info</a>
	</div>
	<div class="col-xs-8">
		<h2 class="pull-right"><?= $numOpen ?> Open Positions</h2>
	</div>
</div>
<div class="row">
	<div class="col-xs-12 text-center">
		<h3 class="">Jurisdiction</h3>
		<a href="/application/basic/web/index.php?r=profile%2Fupdate-region"
               >Update Region</a>
	</div>
</div>