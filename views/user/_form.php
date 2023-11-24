<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\User $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?php if (Yii::$app->controller->action->id === 'create') : ?>
        <?= $form->field($model, 'password_hash')->textInput(['maxlength' => true]) ?>
    <?php endif; ?>
    <?php if (Yii::$app->controller->action->id === 'update') : ?>
        <div>
            <?php foreach ($model->allRoles as $key => $value) : ?>
                <?php

                if ($value === 'guest') continue
                ?>
                <input type="radio" class="btn-check" name="role" value="<?= $value ?>" id="<?= $value ?>" <?= $model->isChecked($value) ?> autocomplete="off">
                <label class="btn btn-outline-dark btn-sm" for="<?= $value ?>"><?= $value ?></label>

            <?php endforeach; ?>
        </div>
    <?php endif; ?>



    <div class="form-group mt-5">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-dark']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>