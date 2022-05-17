<?php

use yii\bootstrap4\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProductAdminSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Товары';
?>
<div class="product-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Создать товар', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Назад', '/admin', ['class' => 'btn btn-primary float-right ml-2']) ?>
        <?= Html::a('Управление категориями', '/admin/category/', ['class' => 'btn btn-primary float-right']) ?>

    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <?php Pjax::begin(['enablePushState' => false, 'timeout' => 5000, 'id' => 'block-pjax']); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            ['attribute' => 'category_id', 'filter' => $categoryArray, 'value' => function($model) use($categoryArray){
                return $categoryArray[$model->category_id];
            }],
            'title',
            'description',
            'price',
            'in_stock',
            'model',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>


</div>