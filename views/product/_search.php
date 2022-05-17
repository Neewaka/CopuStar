<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ProductSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="">Сортировать по:</div>
<ol class="breadcrumb">
    <li class="breadcrumb-item active" aria-current="page"><?= $dataProvider->sort->link('title') ?></li>
    <li class="breadcrumb-item active" aria-current="page"><?= $dataProvider->sort->link('price') ?></li>
    <li class="breadcrumb-item active" aria-current="page"><?= $dataProvider->sort->link('year_of_issue') ?></li>
</ol>

<div class="product-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'category_id')->dropDownList($categoryArray, ['prompt' => 'Все категории'])->label('Выберите категорию') ?>


    <div class="form-group">
        <?= Html::submitButton('Найти', ['class' => 'btn btn-primary']) ?>

        <?= Html::a('Сбросить все', '/product', ['class' => 'btn btn-outline-secondary']) ?>

    </div>

    <?php ActiveForm::end(); ?>

</div>
