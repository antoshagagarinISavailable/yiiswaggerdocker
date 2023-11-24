<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap5\Modal;

/** @var yii\web\View $this */
/** @var app\models\User $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="user-form col-lg-6">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?php if (Yii::$app->controller->action->id === 'update') : ?>
        <?= \yii\helpers\Html::a('Изменить пароль', ['/profile/change-pass'], ['class' => 'btn btn-dark btn-sm']) ?>
    <?php endif; ?>



    <div class="form-group mt-5">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-dark']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>