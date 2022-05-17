<?php

namespace app\models;

use Yii;
use yii\base\Model;

class Cart extends Model
{

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [

        ];
    }

    public static function getCart(){
        $session = Yii::$app->session;

        return $session->has('cart') ? $session->get('cart') : [];
    }

    public static function addProduct($productId)
    {
        if ($product = Product::findOne($productId)) {
            if ($product->in_stock > 0) {
                $session = \Yii::$app->session;

                if (!$session->has('cart')) {
                    $session->set('cart', []);
                }

                $cart = $session->get('cart');

                if (!empty($cart['products'][$product->id])) {
                    if ($cart['products'][$product->id]['count'] < $product->in_stock) {
                        $cart['products'][$product->id]['count']++;
                        $cart['products'][$product->id]['sum'] = $product->price * $cart['products'][$product->id]['count'];
                        $cart['count']++;
                        $cart['sum'] += $product->price;
                    } else {
                        return false;
                    }
                }
                else {
                    $cart['products'][$product->id]['id'] = $product->id;
                    $cart['products'][$product->id]['title'] = $product->title;
                    $cart['products'][$product->id]['price'] = $product->price;
                    $cart['products'][$product->id]['img'] = $product->image;
                    $cart['products'][$product->id]['count'] = 1;
                    $cart['products'][$product->id]['sum'] = $product->price;
                    $cart['count']++;
                    $cart['sum'] += $product->price;
                }

                $session->set('cart', $cart);

                return $cart;
            }
        }
        return false;
    }
 

    public static function deleteFromCart($id, $all_count = false)
    {
        if($product = Product::findOne($id))
        {

            $session = Yii::$app->session;

            if($session->has('cart'))
            {
                $cart = $session->get('cart');

                if(!empty($cart['products'][$id]))
                {
                    $count = $all_count ? $cart['products'][$id]['count'] : 1;
                    $cart['products'][$id]['count'] -= $count;
                    $cart['products'][$id]['sum'] -= $cart['products'][$id]['price'] * $count;
                    $cart['count'] -= $count;
                    $cart['sum'] -= $cart['products'][$id]['price'] * $count;

                    if( empty($cart['products'][$id]['count']))
                    {
                        unset($cart['products'][$id]);
                    }

                    if( !empty($cart['count']))
                    {
                        $session->set('cart', $cart);
                    }
                    else
                    {
                        $session->remove('cart');
                    }
                    
                    return true;
                }
            }
        }

        return false;
    }

}
