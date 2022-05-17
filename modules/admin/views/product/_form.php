<?php

use app\models\Category;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Product */
/* @var $form yii\widgets\ActiveForm */

// var_dump($model);die;
?>

<?= Html::img(Yii::getAlias('@web') . '/images/' . $model->image) ?>



<p>
    <?= Html::a('Назад', '/admin/product', ['class' => 'btn btn-primary float-right ml-2 mb-2']) ?>
</p>

<div class="product-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'category_id')->dropDownList(Category::getArray()) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'price')->textInput() ?>

    <?= $form->field($model, 'in_stock')->textInput() ?>

    <?= $form->field($model,'tempImage')->fileInput() ?>

    <?= $form->field($model, 'producting_country')->textInput(['maxlength' => true]) ?>

    <? // $form->field($model, 'year_of_issue')->textInput() 
    ?>

    <?= $form->field($model, 'model')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>