<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\widgets\Pjax;
?>
<h1 class="text-center mb-3">расчёт стоимости доставки</h1>
<?php Pjax::begin() ?>
<div class="row justify-content-md-center mt-4">
    <div class="col-md-4 mb-4">
        <?php $form = ActiveForm::begin([
            'options' => ['data' => ['pjax' => true]],
        ]) ?>
        <?= $form->field($model, 'raw_type_id')->dropDownList($raw_types, ['prompt' => 'выбрать сырьё', 'id' => 'typeInput']) ?>
        <?= $form->field($model, 'month_id')->dropDownList($months, ['prompt' => 'выбрать месяц', 'id' => 'monthInput']) ?>
        <?= $form->field($model, 'tonnage_id')->dropDownList($tonnages, ['prompt' => 'выбрать тоннаж', 'id' => 'tonnageInput']) ?>
        <?= Html::submitButton('Submit', ['class' => 'btn btn-dark']) ?>
        <?php ActiveForm::end() ?>
    </div>
    <?php if (!empty($res)) : ?>
        <div class="col-md-4 mb-4 border border-dark rounded text-center p-3">
            <h3>Итого</h3>
            <div class="row align-items-center mt-3">
                <div class="col-md-12 align-items-center">
                    <p><span>месяц: </span><span id="month"><?= $res[0]['month'] ?></span></p>
                    <p><span>сырьё: </span><span id="type"><?= $res[0]['raw'] ?></span></p>
                    <p><span>тоннаж: </span><span id="tonnage"><?= $res[0]['tonnage'] ?></span></p>
                    <p><span>цена: </span><span id="price"><?= $res[0]['price'] ?></span></p>

                </div>
            </div>
        </div>

        <div class="col-md-8 mt-3">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">
                        </th>
                        <?php foreach ($months as $key => $month) : ?>
                            <th scope="col"><?= $month ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tonnages
                        as $tonnage_key => $tonnage_value) : ?>
                        <tr>
                            <th scope="row">
                                <?= $tonnage_value ?>
                            </th>


                            <?php foreach ($dataForTable as $data_key => $data_value) : ?>
                                <?php
                                if (
                                    $data_value['value'] == $tonnage_value
                                ) {
                                    echo '<td>';
                                    echo $dataForTable[$data_key]['price'];
                                    echo '</td>';
                                }
                                ?>
                            <?php endforeach; ?>


                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

</div>
<?php Pjax::end() ?>