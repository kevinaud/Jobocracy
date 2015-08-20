<?php
	use yii\helpers\Html;
	use yii\bootstrap\ActiveForm;

	$this->title = 'View Profile';
?>
<h1 class="text-center"><?= Html::encode($tagline) ?></h1>
<h3>Your Information</h3>
<ul>
	<li><label>Username</label>: <?= Html::encode(Yii::$app->user->identity->username) ?></li>
	<li><label>Email</label>: <?= Html::encode(Yii::$app->user->identity->email) ?></li>
	<li><label>Organization</label>: <?= Html::encode(Yii::$app->user->identity->organization) ?></li>
	<li><label>City</label>: <?= Html::encode(Yii::$app->user->identity->city) ?></li>
	<li><label>State</label>: <?= Html::encode(Yii::$app->user->identity->state) ?></li>
</ul>

