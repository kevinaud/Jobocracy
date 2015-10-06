<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <link href='http://fonts.googleapis.com/css?family=PT+Sans' rel='stylesheet' type='text/css'>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>

<?php $this->beginBody() ?>
    <div class="container-fluid">
        <div class="row top-bar">
            <div class="col-xs-2 top-logo">
                <div class="text-center"><span class="logo">   
                    <h1><strong>
                        <a href="/application/basic/web/index.php?r=site%2Findex">JOBOCRACY</a>
                    </strong></h1>
                </span></div>
            </div> 
            <div class="col-xs-10 top-rect">
<?php
if (!Yii::$app->user->isGuest) {       
    echo Nav::widget([
        'options' => ['class' => 'nav nav-pills pull-right logout'],
        'items'   => [
                        ['label' => 'Logout',
                            'url'         => ['/site/logout'],
                            'linkOptions' => [
                                'data-method' => 'post',
                                'class'       => ['btn', 'btn-primary'],
                                'role'        => 'button'
                            ]
                        ],
                     ],
    ]);
}
?>
            </div> <!--TOP-RECT-->
        </div> <!--TOP-BAR-->

        <div class="row content">
            <div class="col-xs-2 side-nav text-center">
            <?php
            if (Yii::$app->user->isGuest) {
                echo '<a href="/application/basic/web/index.php?r=site%2Flogin"
                         class="btn btn-primary btn-sm login">LOGIN</a>';
                echo '<a href="/application/basic/web/index.php?r=site%2Fregister"
                         class="btn btn-primary btn-sm login">REGISTER</a>';
            } else
            {
                echo Nav::widget([
                    'options' => [
                        'class' => 'nav nav-pills nav-stacked', 
                        'id'    => 'myMenu',
                    ],
                    'items' => [
                            [
                                'label' => '<span class="glyphicon glyphicon-user"></span>
                                            <br>PROFILE',
                                'url'   => ['profile/index'],
                            ],
                            [
                                'label' => '<span class="glyphicon glyphicon-list-alt">
                                            </span><br>JOBS LIST',
                                'url'   => ['job/index'],
                            ],
                            [
                                'label' => '<span class="glyphicon glyphicon-stats">
                                            </span><br>METRICS',
                                'url'   => ['meterics/index'],
                            ],
                            [
                                'label' => '<span class="glyphicon glyphicon-tags">
                                            </span><br>MARKET',
                                'url'   => ['market/index'],
                            ],
                    ],
                    'encodeLabels' => false,
                ]);
            }
            ?>
            </div>
            <div class="col-xs-10 main-content">
                    <?= Breadcrumbs::widget([
                        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                    ]) ?>
                    <?= $content ?>
            </div>
        </div>
    </div>



<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>