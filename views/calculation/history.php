<?php

use yii\grid\GridView;
use yii\grid\ActionColumn;

?>

<?php if (\Yii::$app->user->can('admin')) : ?>
<?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'user',
            'month',
            'tonnage',
            'type',
            'result',
            'created_at:datetime',
            [
                'class' => ActionColumn::class,
                'visibleButtons' => [
                    'update' => false,
                ],
            ],
            // ...
        ],
    ]) ?>
<?php endif; ?>
<?php if (!\Yii::$app->user->can('admin')) : ?>
<?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'month',
            'tonnage',
            'type',
            'result',
            'created_at:datetime',
            [
                'class' => ActionColumn::class,
                'visibleButtons' => [
                    'update' => false,
                    'delete' => false,
                ],
            ],
        ],
    ]) ?>
<?php endif; ?>