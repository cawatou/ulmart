<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use webvimark\modules\UserManagement\components\GhostMenu;
use webvimark\modules\UserManagement\UserManagementModule;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>

<?php $this->beginBody() ?>
<div class="wrap">
<?php
/* 
echo GhostMenu::widget([
    'encodeLabels'=>false,
    'activateParents'=>true,
    'items' => [
        [
            'label' => 'Backend routes',
            'items'=>UserManagementModule::menuItems()
        ],
        [
            'label' => 'Frontend routes',
            'items'=>[
                ['label'=>'Вход', 'url'=>['/user-management/auth/login']],
                ['label'=>'Выход', 'url'=>['/user-management/auth/logout']],
                ['label'=>'Регистрация', 'url'=>['/user-management/auth/registration']],
                ['label'=>'Смена пароля', 'url'=>['/user-management/auth/change-own-password']],
                ['label'=>'Восстановление пароля', 'url'=>['/user-management/auth/password-recovery']],
                ['label'=>'Подтверждение e-mail', 'url'=>['/user-management/auth/confirm-email']],
            ],
        ],
    ],
]);*/
?>
    <?php
    NavBar::begin([
        'brandLabel' => 'Перейти на сайт',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            /*       ['label' => 'Home', 'url' => ['/admin/index']],
                   ['label' => 'About', 'url' => ['/admin/about']],
                   ['label' => 'Contact', 'url' => ['/admin/contact']],*/
            Yii::$app->user->isGuest ?
                ['label' => 'Войти', 'url' => ['/admin/login']] :
                ['label' => 'Выйти (' . Yii::$app->user->identity->username . ')',
                    'url' => ['/user-management/auth/logout'],
                    'linkOptions' => ['data-method' => 'post']],
        ],
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <div class="row">
            <div class="col-md-3">
                <br>
                <div class="panel-group" id="accordion">
                    <!-- 1 панель -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">Заявки</a>
                            </h4>
                        </div>
                        <div id="collapseOne" class="panel-collapse collapse">
                            <div class="panel-body">
                                <ul class="nav">
                                    <li><a href="/backend/callback/">Все вопросы</a></li>
                                    <li><a href="/backend/callback/tech/">Технические вопросы</a></li>
                                    <li><a href="/backend/callback/shares/">Вопросы по акции</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- 2 панель -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">Пароли</a>
                            </h4>
                        </div>
                        <div id="collapseTwo" class="panel-collapse collapse">
                            <div class="panel-body">
                                <ul class="nav">
                                    <li><a href="/backend/code/">Список всех паролей</a></li>
                                    <li><a href="/backend/suspectcode/">Неверные пароли</a></li>                                  
                                    <?if(1 == 2):?>
                                        <li><a href="/backend/code/upload/">Загрузка паролей (txt - файл)</a></li>                                        
                                    <?endif?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- 3 панель -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">Сертификаты</a>
                            </h4>
                        </div>
                        <div id="collapseThree" class="panel-collapse collapse">
                            <div class="panel-body">
                                <ul class="nav">
                                    <li><a href="/backend/certificate/">Список сертификатов</a></li>
                                    <li><a href="/backend/certificate/types/">Типы сертификатов</a></li>
                                    <li><a href="/backend/certificate/download/">Выгрузка сертификатов (csv)</a></li>
                                    <?if(1 == 2):?>
                                        <li><a href="/backend/certificate/upload/">Загрузка сертификатов</a></li>
                                    <?endif?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- 4 панель -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a href="/backend/statistic/">Общая статистика по акции</a>
                            </h4>
                        </div>                       
                    </div>
                    <!-- 5 панель -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a href="/backend/suspectip/">Заблокированные IP</a>
                            </h4>
                        </div>                       
                    </div>


                    <?if($_SERVER['REMOTE_ADDR'] == '95.161.6.148'):?>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a href="/backend/clear/">Сброс пароля</a>
                                </h4>
                            </div>
                        </div>
                    <?endif?>
                </div>
            </div>
            <div class="col-md-9">
                <?= $content ?>
            </div>
        </div>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; Ulmart <?= date('Y') ?></p>
        <p class="pull-right">SkipoDevelop</p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
