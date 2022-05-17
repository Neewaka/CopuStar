<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap4\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use yii\bootstrap4\Modal;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body class="d-flex flex-column h-100">
    <?php $this->beginBody() ?>

    <header>
        <?php

        $isAdmin =  !Yii::$app->user->isGuest ? Yii::$app->user->identity->getIsAdmin() : false;

        NavBar::begin([
            'brandLabel' => Yii::$app->name,
            'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                'class' => 'navbar navbar-expand-md navbar-dark bg-dark fixed-top',
            ],
        ]);
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav'],
            'items' => [
                ['label' => 'Каталог', 'url' => ['/product/index']],
                ['label' => 'О нас', 'url' => ['/site/about']],
                ['label' => 'Где нас найти?', 'url' => ['/site/location']],
                ['label' => 'Личный кабинет', 'url' => ['/orders'], 'visible' => !Yii::$app->user->isGuest && !$isAdmin],
                
                $isAdmin ? (['label' => 'Администрирование', 'url' => ['/admin']]
                ) : (''),
                Yii::$app->user->isGuest ? (['label' => 'Регистрация', 'url' => ['/site/registration']]
                ) : (''),
                Yii::$app->user->isGuest ? (['label' => 'Войти', 'url' => ['/site/login']]
                ) : ('<li>'
                    . Html::beginForm(['/site/logout'], 'post', ['class' => 'form-inline'])
                    . Html::submitButton(
                        'Выйти (' . Yii::$app->user->identity->login . ')',
                        ['class' => 'btn btn-link logout']
                    )
                    . Html::endForm()
                    . '</li>'
                )
            ],
        ]);

        if (!($isAdmin || Yii::$app->user->isGuest)) :
        ?>
            <div class="flex-grow-1">
                <div id='cart-link' class="float-right cart-link">Корзина</div>
            </div>
        <?

        endif;


        NavBar::end();
        ?>

        <?
        Modal::begin([
            'title' => 'Корзина',
            'options' => ['id' => 'cart'],
            'size' => 'modal-lg',
            'bodyOptions' => ['id' => 'body-cart'],
            'footer' => Html::button('Очистить корзину', ['class' => 'btn btn-danger m-1', 'id' => 'clear'])
                . Html::button('Продолжить покупки', ['data-dismiss' => 'modal', 'class' => 'btn btn-primary m-1'])
                . Html::a('Оформить заказ', '/orders/create', ['class' => 'btn btn-success m-1', 'id' => 'order']),
        ]);
        Modal::end();

        Modal::begin([
            'title' => 'Ошибка',
            'options' => ['id' => 'modal-error']
        ]);
        echo "<p>Добавлено доступное количество товара.</p>";
        Modal::end();
        ?>



    </header>

    <main role="main" class="flex-shrink-0">
        <div class="container">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    </main>

    <footer class="footer mt-auto py-3 text-muted">
        <div class="container">
            <p class="float-left">&copy; My Company <?= date('Y') ?></p>
            <p class="float-right"><?= Yii::powered() ?></p>
        </div>
    </footer>

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>