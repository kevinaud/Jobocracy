<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use \fruppel\googlecharts\GoogleCharts;

/* @var $this yii\web\View */
/* @var $searchModel app\models\JobSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Workforce Metrics for Your Region';
?>

<div class="metrics-index">

    <h1 class="text-center"><?= Html::encode($this->title) ?></h1>
    <div class="row">
	    <div class="col-xs-5">
	    	<h2 class="text-center">Rapidly Hiring Employers By Industry:</h2>

	    	<?php $form = ActiveForm::begin([
			    'id' => 'industry-form',
			    'options' => ['class' => 'form-horizontal row'],
			]) ?>
			    
		    	<div class="col-xs-10 rapidDrop">
			    	<?= $form->field($model, 'field')
			    			 ->DropDownList([
			    			 	    0 => 'All', 1 => 'Education', 2 => 'Health/Medicine',
									3 => 'Agriculture', 4 => 'Engineering/Manufacturing/Tech',
									5 => 'Business',
			    			 ])->label(false)
			    	?>
			    </div>
				<?= Html::submitButton('Submit', 
					['class' => 'btn btn-default col-xs-2', 'name' => 'industry-button']) ?>
						    			
			<?php ActiveForm::end() ?>

			<?= GridView::widget([
			        'dataProvider' => $dataProvider,
			        'columns' => [
			        	['class' => 'yii\grid\SerialColumn'],
			            'company',
			            [
			            	'attribute' => 'openings', 
			            	'label' => 'Openings in Industry',
			            ]
			        ],
			        'options' => ['class' => 'row'],
				]); 
			?>
		</div>
		<div class="col-xs-7">
			<h2 class="text-center col-xs-12">Job Openings per Industry</h2>
			<div class="col-xs-11 col-xs-offset-1">
			<?= GoogleCharts::widget([
		    'id' => 'my-id',
		    'visualization' => 'PieChart',
		    'data' => [
		        'cols' => [
		            [
		                'id' => 'industry',
		                'label' => 'Industry',
		                'type' => 'string'
		            ],
		            [
		                'id' => 'openings',
		                'label' => 'Openings',
		                'type' => 'number'
		            ]
		        ],
		        'rows' => [
		            [
		                'c' => [
		                    ['v' => 'Education'],
		                    ['v' => $industry[1]]
		                ],
		            ],
		            [
		                'c' => [
		                    ['v' => 'Health/Medicine'],
		                    ['v' => $industry[2]]
		                ]
		            ],
		            [
		                'c' => [
		                    ['v' => 'Agriculture'],
		                    ['v' => $industry[3]]
		                ]
		            ],
		            [
		                'c' => [
		                    ['v' => 'Engineering/Manufacturing/Tech'],
		                    ['v' => $industry[4]]
		                ]
		            ],
		            [
		                'c' => [
		                    ['v' => 'Business'],
		                    ['v' => $industry[5]]
		                ]
		            ],
		        ]
		    ],
		    'options' => [
		        'width' => 700,
		        'height' => 400,
		        'chartArea.width' => 400,
		        'chartArea.height' => 400,
		        'chartArea.top' => 0,
		        'legend.alignment' => 'end',
		    ],
		    'responsive' => true, ]) 
		    ?>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-6">
			<h2>Change in Total # of Listings Over Time</h2>
		</div>
		<div class="col-xs-6">
			<h2>Change in # of Listing per Industry Over Time</h2>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-6">
			<?= GoogleCharts::widget([
			    'visualization' => 'LineChart',
			        'options' => [
			            'hAxis' => [
			                'title' => 'Date',
			                'titleTextStyle' => [
			                    'color' => '#333'
			                ]
			            ],
			            'vAxis' => [
			                'minValue' => 0
			            ],
			            'chartArea' => [
			            	'left' => 0
			            ]
			        ],
			    'dataArray' => [
			            ['Date', 'All Industries'],
			            ['06/22', 47],
			            ['06/29', 49],
			            ['07/06', 58],
			            ['07/13', 59],
			            ['07/20', 62],
			            ['07/27', 66],
			            ['08/03', 65],
			            ['08/10', 67],
			            ['08/17', 71],
			    ]
			]) ?>
		</div>
		<div class="col-xs-6">
			<?= GoogleCharts::widget([
			    'visualization' => 'LineChart',
			        'options' => [
			            'hAxis' => [
			                'title' => 'Date',
			                'titleTextStyle' => [
			                    'color' => '#333'
			                ]
			            ],
			            'vAxis' => [
			                'minValue' => 0
			            ],
			            'chartArea' => [
			            	'left' => 0
			            ]
			        ],
			    'dataArray' => [
			            ['Date', 'Education', 'Health/Medicine', 'Agriculture', 
			            	'Engineering/Manufacturing/Tech','Business'],
			            ['06/22', 6, 11, 10, 15, 5],
			            ['06/29', 6, 13, 9, 17, 4],
			            ['07/06', 5, 16, 14, 19, 4],
			            ['07/13', 5, 16, 12, 22, 4],
			            ['07/20', 5, 21, 13, 18, 5],
			            ['07/27', 7, 23, 16, 14, 6],
			            ['08/03', 7, 24, 15, 14, 5],
			            ['08/10', 7, 25, 18, 13, 4],
			            ['08/17', 8, 27, 19, 13, 4],
			    ]
			]) ?>
		</div>
	</div>
	<br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> 
</div>
