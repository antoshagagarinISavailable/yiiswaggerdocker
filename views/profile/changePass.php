<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Изменить пароль';
$this->params['breadcrumbs'][] = ['label' => \Yii::$app->user->identity->username, 'url' => ['index', 'id' => \Yii::$app->user->id]];
$this->params['breadcrumbs'][] = ['label' => 'изменить', 'url' => ['update', 'id' => \Yii::$app->user->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-lg-4 mt-4">
    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true, 'placeholder' => 'Введите старый пароль'])->label(false) ?>

    <?= $form->field($model, 'newPassword')->passwordInput(['maxlength' => true, 'placeholder' => 'Введите новый пароль'])->label(false) ?>

    <?= $form->field($model, 'newPasswordConfirm')->passwordInput(['maxlength' => true, 'placeholder' => 'Повторите новый пароль'])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton('Изменить пароль', ['class' => 'btn btn-dark']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>