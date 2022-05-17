<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\grid\ActionColumn;

/* @var $this yii\web\View */
/* @var $model app\models\Product */

$this->title = $model->title;

\yii\web\YiiAsset::register($this);
?>
<?php Pjax::begin(['enablePushState' => false, 'timeout' => 5000, 'id' => 'block-pjax']); ?>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'showFooter' => true,
    'footerRowOptions' => ['class' => 'font-weight-bold', 'style' => 'font-size: 1.2em'],
    'pager' => ['class' => \yii\bootstrap4\LinkPager::class],
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        'id',
        [
            'format' => 'raw',
            'attribute' => 'title', 'value' => function ($model) {
                return Html::a("<img src='/images/{$model['img']}' class='w-25'>", '/product/view?id=' . $model['id'])
                    . Html::a($model['title'], ['/product/view?id=' . $model['id']], ['class' => 'ml-3']);
            },
            'label' => 'Наименование',
            'footer' => 'Итого:',

        ],
        [
            'attribute' => 'price',
            'label' => 'Стоимость (руб.)',
            'contentOptions' => ['class' => 'text-center'],
        ],
        [
            'attribute' => 'count',
            'label' => 'Количество',
            'format' => 'raw',
            'value' => function ($model) use ($btn_no) {
                return "<div class='d-flex justify-content-center'>"
                    . (empty($btn_no) ? Html::a("<div>-</div>", [''], ['class' => 'btn-delete btn-rnd mr-2', 'data-key' => $model['id'], 'data-id' => $model['id']]) : '')
                    . $model['count']
                    . (empty($btn_no) ? Html::a("<div>+</div>", [''], ['class' => 'btn-plus btn-rnd ml-2', 'data-key' => $model['id'], 'data-id' => $model['id']]) : '')
                    . '</div>';
            },
            'footer' => $cart['count'],
            'footerOptions' => ['class' => 'text-center'],
        ],
        [
            'attribute' => 'sum',
            'label' => 'Сумма (руб.)',
            'contentOptions' => ['class' => 'text-center'],
            'footer' => $cart['sum'],
            'footerOptions' => ['class' => 'text-center'],
        ],
        [
            // 'class' => ActionColumn::class,
            // 'template' => "{delete}",
            // 'urlCreator' => function ($action, $model, $key, $index, $column) {
            //     return Url::toRoute([$action, 'id' => $model['id']]);
            // },
            // 'buttonOptions' => ['class' => 'text-danger'],
            'format' => 'raw',
            'value' => function ($model) {
                if (empty($btn_no)) {
                    return Html::tag(
                        'span',
                        '<svg aria-hidden="true" style="display:inline-block;font-size:inherit;height:1em;overflow:visible;vertical-align:-.125em;width:.875em" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M32 464a48 48 0 0048 48h288a48 48 0 0048-48V128H32zm272-256a16 16 0 0132 0v224a16 16 0 01-32 0zm-96 0a16 16 0 0132 0v224a16 16 0 01-32 0zm-96 0a16 16 0 0132 0v224a16 16 0 01-32 0zM432 32H312l-9-19a24 24 0 00-22-13H167a24 24 0 00-22 13l-9 19H16A16 16 0 000 48v32a16 16 0 0016 16h416a16 16 0 0016-16V48a16 16 0 00-16-16z"/></svg>',
                        ['class' => 'btn btn-delete-item', 'data-id' => $model['id'], 'style' => 'color: red']

                    );
                };
            }
        ]
    ],
]); ?>
<?php Pjax::end(); ?>

</div>