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
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <script src="/basic/web/js/bootstrap-multiselect.js"></script>
    <script src="/basic/web/js/bootstrap-multiselect-collapsible-groups.js"></script>
    <?php $this->head() ?>
</head>
<body>

<?php $this->beginBody() ?>
    <div class="wrap">
        <div class="row top-bar">
            <div class="col-xs-2 top-logo">
                <div class="text-center"><span class="logo">   
                    <h1><strong><a href="/basic/web/index.php?r=site%2Findex">JOBOCRACY</a></strong></h1>
                </span></div>
            </div> 
            <div class="col-xs-10 top-rect">
<?php
if (!Yii::$app->user->isGuest) {       
    echo Nav::widget([
            'options' => ['class' => 'nav nav-pills pull-right logout'],
            'items' => [
                            ['label' => 'Logout',
                                'url' => ['/site/logout'],
                                'linkOptions' => [
                                    'data-method' => 'post',
                                    'class' => ['btn', 'btn-primary'],
                                    'role' => 'button'
                                ]
                            ],
            ],
    ]);
}
?>
            </div>
        </div>

        <div class="row content">
            <div class="col-xs-2 side-nav text-center">
            <?php
            if (Yii::$app->user->isGuest) {
                echo '<a href="/basic/web/index.php?r=site%2Flogin"
                         class="btn btn-primary btn-sm login">LOGIN</a>';
                echo '<a href="/basic/web/index.php?r=site%2Fregister"
                         class="btn btn-primary btn-sm login">REGISTER</a>';
            } else
            {
                echo Nav::widget([
                    'options' => ['class' => 'nav nav-pills nav-stacked', 'id' => 'myMenu'],
                    'items' => [
                            '<li role="presentation">
                              <a href="/basic/web/index.php?r=site%2Fview-profile">
                                <span class="glyphicon glyphicon-user"></span><br>PROFILE</a>
                            </li>',
                            '<li role="presentation">
                              <a href="/basic/web/index.php?r=job%2Findex">
                                <span class="glyphicon glyphicon-list-alt"></span><br>JOBS LIST</a>
                            </li>',
                            '<li role="presentation">
                              <a href="/basic/web/index.php?r=meterics%2Findex">
                                <span class="glyphicon glyphicon-stats"></span><br>METRICS</a>
                            </li>'
                    ]
                ]);
            }
            ?>
            </div>
            <div class="col-xs-10">
                <div class="container-fluid">
                    <?= Breadcrumbs::widget([
                        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                    ]) ?>
                    <?= $content ?>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <p class="pull-right">&copy; Jobocracy <?= date('Y') ?></p>
        </div>
    </footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>