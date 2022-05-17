<?php

use yii\helpers\Html;

$this->title = 'Администрирование';
?>

<div class="admin-default-index">
    <h1><?= $this->title ?></h1>


    <?= Html::a('Управление категориями', '/admin/category/', ['class' => 'btn btn-primary']) ?>
    <?= Html::a('Управление товарами', '/admin/product/', ['class' => 'btn btn-primary']) ?>
    
</div>
