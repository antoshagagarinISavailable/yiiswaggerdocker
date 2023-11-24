<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap5\Alert;

/** @var yii\web\View $this */
/** @var app\models\User $model */

$this->title = $model->id;
\yii\web\YiiAsset::register($this);
?>
<div class="user-view">

    <?php if (Yii::$app->session->getFlash('successMessage') === 'profilePassChangeSuccess') : ?>
        <?= Alert::widget([
            'options' => [
                'class' => 'alert alert-dark alert-dismissible fade show col-lg-6 container h6',
            ],

            'body' => 'Пароль изменен',
        ]) ?>
    <?php endif; ?>
    <?php if (Yii::$app->session->getFlash('successMessage') === 'profileUpdateSuccess') : ?>
        <?= Alert::widget([
            'options' => [
                'class' => 'alert alert-dark alert-dismissible fade show col-lg-6 container h6',
            ],

            'body' => 'Изменения сохранены',
        ]) ?>
    <?php endif; ?>

    <h1><?= \Yii::$app->user->identity->username ?></h1>

    <p>
        <?= Html::a('Изменить', ['update'], ['class' => 'btn btn-dark']) ?>
        <?php if (!\Yii::$app->user->can('admin')) : ?>
            <?= Html::a('Удалить аккаунт', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-dark',
                'data' => [
                    'confirm' => 'точно?',
                    'method' => 'post',
                ],
            ]) ?>
        <?php endif; ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'username',
            'email:email',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>