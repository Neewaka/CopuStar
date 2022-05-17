<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = 'Где нас найти';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <p> Адрес: Ул. Пушкина д. А какой дом то? </p>
    <p> Email: email@mail.com</p>
    <p> Номер телефона: +79999999999</p>

    <?= Html::img(Yii::getAlias('@web') . '/images/location.jpg') ?>

    <code><?= __FILE__ ?></code>
</div>