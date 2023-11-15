<?php

use yii\grid\GridView;
use yii\widgets\DetailView;

?>
<h1 class="mt-1 mb-4 text-center">расчёт</h1>
<?php if (\Yii::$app->user->can('admin')) : ?>
    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'user',
            'month',
            'tonnage',
            'type',
            'result',
            // [                      // the owner name of the model
            //     'label' => 'Owner',
            //     'value' => $model->owner->name,
            // ],
            'created_at:datetime', // creation date formatted as datetime
        ],
    ]);
    ?>
<?php endif; ?>
<?php if (!\Yii::$app->user->can('admin')) : ?>
    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'month',
            'tonnage',
            'type',
            'result',
            // [                      // the owner name of the model
            //     'label' => 'Owner',
            //     'value' => $model->owner->name,
            // ],
            'created_at:datetime', // creation date formatted as datetime
        ],
    ]);
    ?>
<?php endif; ?>


<div class="col-md-12 mt-5 table-responsive">
    <table class="table text-center">
        <thead class="table-light">
            <tr>
                <th scope="col" class="text-muted small">
                    т\м
                </th>
                <?php foreach ($model->getAllMonths() as $key => $month) : ?>
                    <th scope="col"><?= $month ?></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($model->getAllTonnages()
                as $tonnage_key => $tonnage_value) : ?>
                <tr>
                    <th scope="row">
                        <?= $tonnage_value ?>
                    </th>

                    <?php foreach ($model->getDataForTable() as $data_key => $data_value) : ?>
                        <?php if ($data_value['value'] == $tonnage_value) : ?>
                            <?php
                            if (
                                $model->getDataForTable()[$data_key]['price'] == $model->result &&
                                $model->getDataForTable()[$data_key]['name'] == $model->month
                            ) {
                                echo '<td class="fw-bold text-danger">';
                            } else {
                                echo '<td>';
                            }
                            ?>
                            <?= $model->getDataForTable()[$data_key]['price'] ?>
                            </td>
                        <?php endif; ?>
                    <?php endforeach; ?>

                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>