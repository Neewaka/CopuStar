<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap4\ActiveForm $form */
/** @var app\models\ContactForm $model */

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

use yii\widgets\Pjax;

$this->title = 'Registration';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>



    <div class="row">
        <div class="col-lg-5">

            <?php Pjax::begin(['enablePushState' => false, 'enableReplaceState' => false, 'timeout' => 5000]);
            $form = ActiveForm::begin(['id' => 'contact-form', 'options' => ['data-pjax' => true]]); ?>

            <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>

            <?= $form->field($model, 'surname') ?>

            <?= $form->field($model, 'patronymic') ?>

            <?= $form->field($model, 'login') ?>

            <?= $form->field($model, 'email') ?>

            <?= $form->field($model, 'password') ?>

            <?= $form->field($model, 'password_repeat') ?>

            <?= $form->field($model, 'rules')->checkbox() ?>

            <div class="form-group">
                <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
            </div>

            <?php ActiveForm::end();
            Pjax::end(); ?>

        </div>
    </div>
</div>