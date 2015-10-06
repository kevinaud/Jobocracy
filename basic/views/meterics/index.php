<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use \fruppel\googlecharts\GoogleCharts;

/* @var $this yii\web\View */
/* @var $searchModel app\models\JobSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Workforce Metrics for Your Region';

function displayTriangle($change){
	if($change < 0){
		echo '<span class="glyphicon glyphicon-triangle-bottom"></span>';
	}
	else {
		echo '<span class="glyphicon glyphicon-triangle-top"></span>';
	}
}

?>

<div class="metrics-index">
	<div class="row">
		<div class="col-xs-12 data-module areachart-module">
			<?= GoogleCharts::widget([
			    'visualization' => 'AreaChart',
			        'options' => [
			        	'fontName' => 'PT Sans',
			            'vAxis' => [
			            	'title' => '# of Job Listings
			            	',
			                'minValue' => 0
			            ],
			            'axisTitlesPosition' => 'out',
			            'chartArea' => [
			            	'left' => '8%',
			            	'right' => '8%',
			            ],
			            'lineWidth' => 5,
			            'legend' => [
			            	//'position' => 'top',
			            ],
			            'height' => '300',
			            'width' => '70%',
			            'colors' => [
			            	'#427CE3',
			            	'#4687A9',
			            	'#60CED0',
			            	'#B4ECD7',
			            	'#718BB2',
			            	'#78ACFD',
			            ],
			            'backgroundColor' => '#F0F0F0',
			        ],
			    'dataArray' => $byIndrLine,
			]) ?>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-7 data-module pie-module">
		<div class="row">
			<div class="col-xs-5 col-xs-offset-1">
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
		                    ['v' => 'Edu'],
		                    ['v' => $lastMonthInd['edu']['num']]
		                ],
		            ],
		            [
		                'c' => [
		                    ['v' => 'Health/Med'],
		                    ['v' => $lastMonthInd['health']['num']]
		                ]
		            ],
		            [
		                'c' => [
		                    ['v' => 'Agric'],
		                    ['v' => $lastMonthInd['agr']['num']]
		                ]
		            ],
		            [
		                'c' => [
		                    ['v' => 'Engr/Manu/Tech'],
		                    ['v' => $lastMonthInd['eng']['num']]
		                ]
		            ],
		            [
		                'c' => [
		                    ['v' => 'Business'],
		                    ['v' => $lastMonthInd['bus']['num']]
		                ]
		            ],
		        ]
		    ],
		    'options' => [
		    	'fontName' => 'PT Sans',
		        'width' => '100%',
		        'height' => '100%',
		        'chartArea' => [
		        	'width' => '92%',
		        	'height' => '92%',
		        ],
		        'legend' => [
		        	'position' => 'none',
		        ],
		        'colors' => [
	            	'#427CE3',
	            	'#4687A9',
	            	'#60CED0',
	            	'#B4ECD7',
	            	'#718BB2',
	            	'#78ACFD',
			    ],
			    'backgroundColor' => '#F0F0F0',
		    ],
		    'responsive' => true, ]) 
		    ?>
			</div>
			<div class="col-xs-5 col-xs-offset-1">
			<?= GoogleCharts::widget([
		    'id' => 'an-id',
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
		                    ['v' => 'Edu'],
		                    ['v' => $industry['edu']['num']]
		                ],
		            ],
		            [
		                'c' => [
		                    ['v' => 'Health/Med'],
		                    ['v' => $industry['health']['num']]
		                ]
		            ],
		            [
		                'c' => [
		                    ['v' => 'Agric'],
		                    ['v' => $industry['agr']['num']]
		                ]
		            ],
		            [
		                'c' => [
		                    ['v' => 'Engr/Manu/Tech'],
		                    ['v' => $industry['eng']['num']]
		                ]
		            ],
		            [
		                'c' => [
		                    ['v' => 'Business'],
		                    ['v' => $industry['bus']['num']]
		                ]
		            ],
		        ]
		    ],
		    'options' => [
		    	'fontName' => 'PT Sans',
		        'width' => '100%',
		        'height' => '100%',
		        'chartArea' => [
		        	'width' => '92%',
		        	'height' => '92%',
		        ], 
		        'legend' => [
		        	'position' => 'none',
		        ],
		        'colors' => [
	            	'#427CE3',
	            	'#4687A9',
	            	'#60CED0',
	            	'#B4ECD7',
	            	'#718BB2',
	            	'#78ACFD',
			    ],
			    'backgroundColor' => '#F0F0F0',
		    ],
		    'responsive' => true, ]) 
			?>
			</div>
		</div>
		<div class="row module-row-">
			<div class="col-xs-3 col-xs-offset-2">
				<h4 class="text-center">Last Month</h4>
			</div>
			<div class="col-xs-3">
				<h4 class="text-center">Changes</h4>
			</div>
			<div class="col-xs-3">
				<h4 class="text-center">Today</h4>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-2 pie-list">
				<ul>
					<li class="text-right"><strong>Edu</strong></li>
					<li class="text-right"><strong>Health/Med</strong></li>
					<li class="text-right"><strong>Agric</strong></li>
					<li class="text-right"><strong>Engr/Man/Tech</strong></li>
					<li class="text-right"><strong>Business</strong></li>
				</ul>
			</div>
			<div class="col-xs-3 pie-list">
				<ul>
					<li class="text-center">
						<?= $lastMonthInd['edu']['num'].'&nbsp;' ?>
						<?= '('.round($lastMonthInd['edu']['perc'],1).'%)' ?></li>
					<li class="text-center">
						<?= $lastMonthInd['health']['num'].'&nbsp;' ?>
						<?= '('.round($lastMonthInd['health']['perc'],1).'%)' ?></li>
					<li class="text-center">
						<?= $lastMonthInd['agr']['num'].'&nbsp;' ?>
						<?= '('.round($lastMonthInd['agr']['perc'],1).'%)' ?></li>
					<li class="text-center">
						<?= $lastMonthInd['eng']['num'].'&nbsp;' ?>
						<?= '('.round($lastMonthInd['eng']['perc'],1).'%)' ?></li>
					<li class="text-center">
						<?= $lastMonthInd['bus']['num'].'&nbsp;' ?>
						<?= '('.round($lastMonthInd['bus']['perc'],1).'%)' ?></li>
				</ul>
			</div>
			<div class="col-xs-3 pie-list month-change">
				<ul>
					<li>
						<?php displayTriangle($monthChange['edu']['num']); ?>
						<?= abs($monthChange['edu']['num']).' ' ?>
						<?= '('.round(abs($monthChange['edu']['perc']),1).'%)'?>
					</li>
					<li>
						<?php displayTriangle($monthChange['health']['num']); ?>
						<?= abs($monthChange['health']['num']).'&nbsp;('
							.round(abs($monthChange['health']['perc']),1).'%)'?>
					</li>
					<li>
						<?php displayTriangle($monthChange['agr']['num']); ?>
						<?= abs($monthChange['agr']['num']).' ' ?>
						<?= '('.round(abs($monthChange['agr']['perc']),1).'%)'?>
					</li>
					<li>
						<?php displayTriangle($monthChange['eng']['num']); ?>
						<?= abs($monthChange['eng']['num']).' ' ?>
						<?= '('.round(abs($monthChange['eng']['perc']),1).'%)'?>
					</li>
					<li>
						<?php displayTriangle($monthChange['bus']['num']); ?>
						<?= abs($monthChange['bus']['num']).' ' ?>
						<?= '('.round(abs($monthChange['bus']['perc']),1).'%)'?>
					</li>
				</ul>
			</div>
			<div class="col-xs-3 pie-list">
				<ul>
					<li class="text-center"><?= $industry['edu']['num'].' ' ?>
						<?= '('.round($industry['edu']['perc'],1).'%)' ?></li>
					<li class="text-center"><?= $industry['health']['num'].' ' ?>
						<?= '('.round($industry['health']['perc'],1).'%)' ?></li>
					<li class="text-center"><?= $industry['agr']['num'].' ' ?>
						<?= '('.round($industry['agr']['perc'],1).'%)' ?></li>
					<li class="text-center"><?= $industry['eng']['num'].' ' ?>
						<?= '('.round($industry['eng']['perc'],1).'%)' ?></li>
					<li class="text-center"><?= $industry['bus']['num'].' ' ?>
						<?= '('.round($industry['bus']['perc'],1).'%)' ?></li>
				</ul>
			</div>
		</div>
		</div>
		<div class="col-xs-5 data-module rapidlyHiring">
	    	<h2 class="text-center">TOP EMPLOYERS</h2>

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
				]); 
			?>
		</div>
	</div>
	<br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> 

</div>
