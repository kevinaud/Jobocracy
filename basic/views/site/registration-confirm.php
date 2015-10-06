<?php
	use yii\helpers\Html;
?>
<div class="row">
	<div class="col-xs-12">
		<h1 class="text-center">Registration Successful</h1>
	</div>
</div>
<div class="row">
	<div class="col-xs-12">
		<p><strong>Email:</strong> <?= $model->email ?></p>
		<p><strong>Username:</strong> <?= $model->username ?></p>
		<p><strong>Organization:</strong> <?= $model->organization ?></p>
		<p><strong>City:</strong> <?= $model->county ?></p>
		<p><strong>State:</strong> <?= $model->state ?></p>
	</div>
</div>