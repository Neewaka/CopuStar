<?php

use yii\helpers\Url;

$route = Url::to(['product/view', 'id' => $model->id]);

?>


<div class="card">
  <a href=<?= $route ?> class="d-block image-container"> <img src=<?= Yii::getAlias('@web') . '/images/' . $model->image ?> class="card-img-top d-block" alt="..."></a>
  <div class="card-body">
    <h5 class="card-title"><a href=<?= $route ?> class="text-decoration-none text-reset"><?= $model->title ?></a></h5>
    <p class="card-text"><?= $model->price . '$' ?></p>
    <? if (!$isAdmin) : ?>
      <a href="#" data-id=<?=$model->id?> class="btn btn-primary btn-block add-to-cart">Добавить в корзину</a>
    <? endif; ?>
  </div>
</div>