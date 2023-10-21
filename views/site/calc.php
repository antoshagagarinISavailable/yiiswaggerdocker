<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\widgets\Pjax;
?>
<h1 class="text-center mb-5 h4">расчёт стоимости доставки</h1>
<?php Pjax::begin() ?>
<div class="row justify-content-md-center mt-4">
    <div class="col-md-4 mb-4">
        <?php $form = ActiveForm::begin([
            'options' => ['data' => ['pjax' => true]],
        ]) ?>
        <?= $form->field($model, 'raw_type_id')->dropDownList($model->allRaws(), ['prompt' => 'выбрать сырьё', 'id' => 'typeInput']) ?>
        <?= $form->field($model, 'month_id')->dropDownList($model->allMonths(), ['prompt' => 'выбрать месяц', 'id' => 'monthInput']) ?>
        <?= $form->field($model, 'tonnage_id')->dropDownList($model->allTonnages(), ['prompt' => 'выбрать тоннаж', 'id' => 'tonnageInput']) ?>
        <?= Html::submitButton('Submit', ['class' => 'btn btn-dark']) ?>
        <?php ActiveForm::end() ?>
    </div>
    <?php if (!empty($calc_res)) : ?>
        <div class="col-md-4 mb-4 border border-dark rounded text-center p-3">
            <h3 class="text-decoration-underline text-muted">Итого</h3>
            <div class="row align-items-center mt-3">
                <div class="col-md-12 align-items-center">
                    <p><span>месяц: </span><span id="month"><?= $calc_res['month'] ?></span></p>
                    <p><span>сырьё: </span><span id="type"><?= $calc_res['raw'] ?></span></p>
                    <p><span>тоннаж: </span><span id="tonnage"><?= $calc_res['tonnage'] ?></span></p>
                    <p><span>цена: </span><span class="fw-bold text-danger" id="price"><?= $calc_res['price'] ?></span></p>

                </div>
            </div>
        </div>

        <div class="col-md-8 mt-3 table-responsive">
            <table class="table text-center">
                <thead class="table-light">
                    <tr>
                        <th scope="col" class="text-muted small">
                            т\м
                        </th>
                        <?php foreach ($model->allMonths() as $key => $month) : ?>
                            <th scope="col"><?= $month ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($model->allTonnages()
                        as $tonnage_key => $tonnage_value) : ?>
                        <tr>
                            <th scope="row">
                                <?= $tonnage_value ?>
                            </th>

                            <?php foreach ($dataForTable as $data_key => $data_value) : ?>
                                <?php if ($data_value['value'] == $tonnage_value) : ?>
                                    <?php
                                    if (
                                        $dataForTable[$data_key]['price'] == $calc_res['price'] &&
                                        $dataForTable[$data_key]['name'] == $calc_res['month']
                                    ) {
                                        echo '<td class="fw-bold text-danger">';
                                    } else {
                                        echo '<td>';
                                    }
                                    ?>
                                    <?= $dataForTable[$data_key]['price'] ?>
                                    </td>
                                <?php endif; ?>
                            <?php endforeach; ?>

                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

</div>
<?php Pjax::end() ?>