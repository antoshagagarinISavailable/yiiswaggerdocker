<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Dropdown;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">

<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body class="d-flex flex-column h-100">
    <?php $this->beginBody() ?>

    <header id="header">
        <?php
        NavBar::begin([
            'brandLabel' => Yii::$app->name,
            // 'brandUrl' => Yii::$app->homeUrl,
            'brandUrl' => '/site/index',
            'options' => [
                'class' => 'navbar-expand-md navbar-dark bg-dark fixed-top',
                'data-bs-theme' => 'dark'
            ]
        ]);
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav'],
            'items' => [
                ['label' => 'Home', 'url' => ['/site/index']],
                ['label' => 'Calc', 'url' => ['/site/calc']],
                // ['label' => 'OOP', 'url' => ['/site/oop']],
            ]
        ]);
        ?>

        <?php if (!Yii::$app->user->can('user')) : ?>
            <div class="navbar-nav ms-auto">
                <?= Html::a('Войти', ['/site/login'], ['class' => 'btn btn-outline-light mx-3 btn-sm']) ?>
                <?= Html::a('Регистрация', ['/site/register'], ['class' => 'btn btn-outline-light btn-sm']) ?>
            </div>
        <?php endif; ?>

        <?php if (Yii::$app->user->can('user')) : ?>
            <div class="dropdown navbar-nav ms-auto">
                <a class="nav-link text-light dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <?= Yii::$app->user->identity->username ?>
                </a>
                <?php
                echo Dropdown::widget([
                    'options' => ['class' => 'dropdown-menu dropdown-menu-end'],

                    'items' => [
                        ['label' => 'Профиль', 'url' => '/profile'],
                        ['label' => 'История расчетов', 'url' => ['calculation/history']],
                        Yii::$app->user->can('admin')
                            ? ['label' => 'Пользователи', 'url' => ['/user']]
                            : '',
                        '<li>
                        <hr class="dropdown-divider">
                        </li>',
                        Html::beginForm(['/site/logout'], 'post')
                            . Html::submitButton(
                                'Выход',
                                ['class' => 'dropdown-item']
                            )
                            . Html::endForm(),
                    ],
                ]);
                ?>
            </div>
        <?php endif; ?>

        <?php NavBar::end(); ?>
    </header>

    <main id="main" class="flex-shrink-0" role="main">
        <div class="container">
            <?php if (!empty($this->params['breadcrumbs'])) : ?>
                <?php
                echo Breadcrumbs::widget([
                    'links' => $this->params['breadcrumbs'],
                    'options' => ['style' => "--bs-breadcrumb-divider: '-'"],
                ]) ?>
            <?php endif ?>
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    </main>

    <footer id="footer" class="mt-auto py-3 bg-light">
        <div class="container">
            <div class="row text-muted">
                <div class="col-md-6 text-center text-md-start">&copy; calc <?= date('Y') ?></div>
                <div class="col-md-6 text-center text-md-end">@</div>
            </div>
        </div>
    </footer>

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>