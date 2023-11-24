<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap5\Alert;

/** @var yii\web\View $this */
/** @var app\models\User $model */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-view">

    <?php if (Yii::$app->session->getFlash('successMessage') === 'userCreated') : ?>
        <?= Alert::widget([
            'options' => [
                'class' => 'alert alert-dark alert-dismissible fade show col-lg-6 container h6',
            ],

            'body' => 'пользователь \'' . $model->username . '\' создан',
        ]) ?>
    <?php endif; ?>
    <?php if (Yii::$app->session->getFlash('successMessage') === 'userUpdated') : ?>
        <?= Alert::widget([
            'options' => [
                'class' => 'alert alert-dark alert-dismissible fade show col-lg-6 container h6',
            ],

            'body' => 'пользователь \'' . $model->username . '\' изменён',
        ]) ?>
    <?php endif; ?>

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-dark btn-sm']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-dark btn-sm',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'username',
            'auth_key',
            'password_hash',
            'password_reset_token',
            'email:email',
            'status',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>