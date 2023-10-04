<?php
$prices = require_once __DIR__ . '/../../config/prices.php';

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\widgets\Pjax;
?>
<h1 class="text-center">Shipping cost calculator</h1>
<?php Pjax::begin() ?>
<div class="row justify-content-md-center mt-4">
    <div class="col-md-4 mb-4">
        <?php $form = ActiveForm::begin([
            'options' => ['data' => ['pjax' => true]],
        ]) ?>
        <?= $form->field($model, 'raw')->dropDownList($prices['raw']) ?>
        <?= $form->field($model, 'month')->dropDownList($prices['months']) ?>
        <?= $form->field($model, 'tonnage')->dropDownList($prices['tonnage']) ?>
        <?= Html::submitButton('Submit', ['class' => 'btn btn-dark']) ?>
        <?php ActiveForm::end() ?>
    </div>
    <?php if ($data) : ?>
        <div class="col-md-4 mb-4 border border-dark rounded text-center p-3">
            <h3>shipping cost</h3>
            <div class="row align-items-center mt-3">
                <div class="col-md-12 align-items-center">
                    <p>
                        <?php
                        if ($data) {
                            $arr = $data['CalcForm'];
                            echo '<span>raw: </span>';
                            echo '<span>';
                            echo $arr['raw'];
                            echo '</span>';
                        }
                        ?>
                    </p>
                    <p>

                        <span>
                            <?php
                            if ($data) {
                                $arr = $data['CalcForm'];
                                echo '<span>month: </span>';
                                echo '<span>';
                                echo $arr['month'];
                                echo '</span>';
                            }
                            ?>
                        </span>
                    </p>
                    <p>
                        <?php
                        if ($data) {
                            $arr = $data['CalcForm'];
                            echo '<span>tonnage: </span>';
                            echo '<span>';
                            echo $arr['tonnage'];
                            echo '</span>';
                        }
                        ?>
                    </p>
                    <p>
                        <?php
                        if ($data) {
                            $arr = $data['CalcForm'];
                            echo 'price: ';
                            echo $prices[$arr['raw']][$arr['month']][$arr['tonnage']];
                        }
                        ?>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-8 mt-3">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">
                        </th>
                        <?php foreach ($prices['months'] as $month) : ?>
                            <th scope="col"><?= $month ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($prices[$data['CalcForm']['raw']][$data['CalcForm']['month']]
                        as $tonnage => $value) : ?>
                        <tr>
                            <th scope="row">
                                <?= $tonnage ?>
                            </th>
                            <?php foreach ($prices[$data['CalcForm']['raw']]
                                as $month => $month_info) : ?>
                                <td>
                                    <?= $month_info[$tonnage] ?>
                                </td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>
<?php Pjax::end() ?>