<?php

use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Orders */

$this->title = 'Create Orders';

?>
<div class="orders-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('../cart/view.php', ['cart' => $cart, 'dataProvider' => $dataProvider, 'btn_no' => true])  ?>

    <div class="mt-3" id="agree">
        <?php $form = ActiveForm::begin([
            'id' => 'confirm-form',
            'enableAjaxValidation' => true,
        ]); ?>

        <div class="offset-7 col-5 align-items-start justify-content-end">
            <?= $form->field($login, 'password')->passwordInput(['placeholder' => 'Введите ваш пароль', 'id' => 'psw'])->label('Для подтверждения заказа введите свой пароль') ?>
            <?= Html::submitButton('Сформировать заказ', ['class' => 'btn btn-primary flex-fill', 'name' => 'confirm-button', 'id' => 'agree']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>