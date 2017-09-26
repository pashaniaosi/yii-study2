<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::t('common', 'Blog'),
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $navLeft=[
        ['label' => Yii::t('yii', 'Home'), 'url' => ['/site/index']],
//        ['label' => Yii::t('common', 'About'), 'url' => ['/site/about']],
//        ['label' => Yii::t('common', 'Contact'), 'url' => ['/site/contact']],
        ['label' => Yii::t('common', 'Post'), 'url' => ['/post/index']],
    ];
//    $navRight = [];
    if (Yii::$app->user->isGuest) {
        $navRight[] = ['label' => Yii::t('common', 'Signup'), 'url' => ['/site/signup']];
        $navRight[] = ['label' => Yii::t('common', 'Login'), 'url' => ['/site/login']];
//        array_push($navRight,['label' => Yii::t('common', 'Login'), 'url' => ['/site/login']],['label' => Yii::t('common', 'Signup', 'url' => ['/site/signup']]);
    } else {
//        array_push($navRight,['label' => '<img src = "'.Yii::$app->params['avatar']['defaultImage'].'"alt="'. Yii::$app->user->identity->username.'"> ',
//                'linkOptions' => ['class' => 'avatar'],
//                'items' => [
//                    ['label' => '退出', 'url' => ['/site/logout'], 'linkOptions' => ['data-method' => 'post']],
//                    ['label' => '个人中心'],
//                ],
//            ]
//        );
//        之后要添加登录头像
        $navRight[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                'Logout (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>';

    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-left'],
        'items' => $navLeft,
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
//        不过滤代码标签
        'encodeLabels' => false,
        'items' => $navRight,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
