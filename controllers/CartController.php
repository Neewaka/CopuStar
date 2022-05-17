<?php

namespace app\controllers;

use app\models\Cart;
use app\models\Product;
use yii\filters\AccessControl;
use Yii;
use yii\data\ArrayDataProvider;

class CartController extends \yii\web\Controller
{

    public function actionAdd()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->post()) {
            if ($id = Yii::$app->request->post('id')) {
                return $this->asJson(Cart::addProduct($id));
            }
        }
    }

    public function actionView()
    {
        if (Yii::$app->request->isPost) {
            $cart = Cart::getCart();

            if (!empty($cart['count'])) {


                $dataProvider = new ArrayDataProvider(['allModels' => $cart['products'], 'pagination' => [
                    'pageSize' => 2,
                ]]);

                return $this->renderPartial('view', ['cart' => $cart, 'dataProvider' => $dataProvider]);
            }

            
        }

        // $cart = Cart::getCart();

        // $dataProvider = new ArrayDataProvider(['allModels' => $cart['products'], 'pagination' => [
        //     'pageSize' => 2,
        // ]]);

        // return $this->render('view', ['cart' => $cart, 'dataProvider' => $dataProvider]);
    }

    public function actionClear(){
        Yii::$app->session->remove('cart');
        return $this->asJson(true);
    }

    public function actionDeleteOneItem()
    {
        if( Yii::$app->request->isPost && Yii::$app->request->isAjax)
        {
            if($id = Yii::$app->request->post('id'))
            {
                return $this->asJson(Cart::deleteFromCart($id));
            }
        }
    }

    public function actionDeleteItem()
    {
        if( Yii::$app->request->isPost && Yii::$app->request->isAjax)
        {
            if($id = Yii::$app->request->post('id'))
            {
                return $this->asJson(Cart::deleteFromCart($id, true));
            }
        }
    }
}
