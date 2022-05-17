<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "orderitems".
 *
 * @property int $id
 * @property int $id_order
 * @property int $id_product
 * @property int $price
 * @property int $count
 *
 * @property Orders $order
 * @property Product $product
 */
class Orderitems extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'orderitems';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_order', 'id_product', 'price', 'count'], 'required'],
            [['id_order', 'id_product', 'price', 'count'], 'integer'],
            [['id_order'], 'exist', 'skipOnError' => true, 'targetClass' => Orders::className(), 'targetAttribute' => ['id_order' => 'id']],
            [['id_product'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['id_product' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_order' => 'Id Order',
            'id_product' => 'Id Product',
            'price' => 'Price',
            'count' => 'Count',
        ];
    }

    /**
     * Gets query for [[Order]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Orders::className(), ['id' => 'id_order']);
    }

    /**
     * Gets query for [[Product]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'id_product']);
    }

    public static function orderItemsCreate($cart, $order_id)
    {
        foreach ($cart['products'] as $item) {
            if ($product = Product::findOne($item['id'])) {
                $order_product = new static();
                $order_product->id_order = $order_id;
                $order_product->id_product = $item['id'];
                $order_product->price = $item['price'];
                $order_product->title = $item['title'];
                $order_product->count = $item['count'];

                if ($res = $order_product->save()) {
                    $product->in_stock -= $item['count'];
                    $res = $product->save();
                }

                if (!$res) {
                    return $res;
                }
            }
        }

        return true;
    }
}
