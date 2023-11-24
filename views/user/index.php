<?php

use app\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\bootstrap5\Alert;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Все пользователи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <?php if (Yii::$app->session->getFlash('successMessage') === 'userDeleted') : ?>
        <?= Alert::widget([
            'options' => [
                'class' => 'alert alert-dark alert-dismissible fade show col-lg-6 container h6',
            ],

            'body' => 'пользователь удалён',
        ]) ?>
    <?php endif; ?>

    <h1><?= $this->title ?></h1>

    <p>
        <?= Html::a('Новый пользователь', ['create'], ['class' => 'btn btn-dark btn-sm']) ?>
    </p>

    <div class="table-responsive">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'id',
                'username',
                // 'auth_key',
                // 'password_hash',
                // 'password_reset_token',
                'email:email',
                'status',
                'created_at',
                // 'updated_at',
                [
                    'class' => ActionColumn::className(),
                    'urlCreator' => function ($action, User $model, $key, $index, $column) {
                        return Url::toRoute([$action, 'id' => $model->id]);
                    }
                ],
            ],
        ]); ?>
    </div>



</div>