<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\JobSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Job Listings in Your Region';
?>
<div class="job-index">

    <h1  class="text-center"><?= Html::encode($this->title) ?></h1>
    <?php //echo $this->render('_search', ['model' => $searchModel]); ?>    

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'jobField.name',
                'format' => 'text',
                'label' => 'Industry',
                //'filter' => '<input type="text" name="JobSearch[jobField.name]" class="form-control">'
            ],
            'title',
            'company',
            [
                'attribute' => 'city.name',
                'format' => 'text',
                'label' => 'City',
            ],
            [
                'attribute' => 'county.name',
                'format' => 'text',
                'label' => 'County',
            ],
            [
                'attribute' => 'state.name',
                'format' => 'text',
                'label' => 'State'
            ],
            [
                'attribute' => 'phone_number',
                'format' => 'text',
                'filter' => false
            ],
            [
                'attribute' => 'date_posted',
                'format' => ['date', 'short'],
                'label' => 'Date Posted',
                'filter' => false,
            ],
            [
                'attribute' => 'url',
                'label' => 'Hyperlink',
                'visible' => false,
                'filter' => false,
            ],

            ['class' => 'yii\grid\ActionColumn', 'template' => '{view}'],
        ],
    ]); ?>

</div>

