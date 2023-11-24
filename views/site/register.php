<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>

<?= $form->field($model, 'password_confirmation')->passwordInput(['maxlength' => true]) ?>

<div class="form-group">
    <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-dark']) ?>
</div>

<?php ActiveForm::end(); ?>