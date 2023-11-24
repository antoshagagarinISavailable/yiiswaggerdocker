<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\User $model */

$this->title = 'Создать нового пользователя';
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create col-lg-4">

    <h1>Создать нового пользователя:</h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>