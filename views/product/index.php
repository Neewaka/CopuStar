<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\widgets\ListView;
use yii\widgets\Pjax;
use yii\bootstrap4\Modal;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Каталог';
?>
<div class="product-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php Pjax::begin(['enablePushState' => false, 'timeout' => 5000, 'id' => 'block-pjax']); ?>
    <?php echo $this->render('_search', ['model' => $searchModel, 'categoryArray' => $categoryArray, 'dataProvider' => $dataProvider, 'categoryArray' => $categoryArray]); ?>

    <?= ListView::widget([
        'layout' => '{pager}<div class="row row-cols-4" style="row-gap: 30px">{items}</div>{pager}',
        'pager' => ['class' => yii\bootstrap4\LinkPager::class],
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item col-3'],
        'itemView' => function($model) use ($isAdmin) {
            return $this->render('_card', ['model' => $model, 'isAdmin' => $isAdmin]);
        }
    ]) ?>

    <?php Pjax::end(); ?>


</div>