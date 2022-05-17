<?php

/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\bootstrap4\Carousel;

$this->title = 'О нас';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= Html::img(Yii::getAlias('@web') . '/images/comp-l1dl4qgmsvgcontent1650295662.png')?>

    <p>
        <b>Девиз компании:</b> Lorem ipsum dolor sit amet consectetur adipisicing elit. Asperiores porro fugiat molestias velit dolorum, quam dolores similique voluptatibus culpa voluptate aperiam illum sint ullam veritatis exercitationem. Similique accusamus enim distinctio.
    </p>


    <?
    $carouselItems = [];
    foreach($recentFive as $item)
    {
        $carouselItems[] = ['content' => Html::img(Yii::getAlias('@web') . '/images/' . $item->image)];
    }

    $imageB = Html::img(Yii::getAlias('@web') . '/images/' . 'location.jpg');
    echo Carousel::widget([
    'items' =>  $carouselItems,
    
]);?>

    <code><?= __FILE__ ?></code>
</div>
