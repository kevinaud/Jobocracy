<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Job */

$this->title = $model->title;
?>
<div class="job-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'jobField.name:text:Industry',
            'title',
            'company',
            'city.name:text:City',
            'county.name:text:County',
            'state.name:text:State',
            'phone_number',
            'date_posted',
            'url:url',
        ],
    ]) ?>

</div>
