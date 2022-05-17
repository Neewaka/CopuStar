<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property int $category_id
 * @property string $title
 * @property string $description
 * @property string $image 
 * @property int $price
 * @property string $producting_country
 * @property string $year_of_issue
 * @property string $model
 */
class Product extends \yii\db\ActiveRecord
{

    const SCENARIO_UPLOAD = 'upload';
    public $tempImage;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id', 'title', 'description', 'price', 'producting_country', 'model'], 'required'],
            ['image', 'required', 'on' => self::SCENARIO_UPLOAD],
            [['category_id', 'price', 'in_stock'], 'integer'],
            [['description'], 'string'],
            [['year_of_issue'], 'safe'],
            [['title', 'image', 'producting_country', 'model'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']], 
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Категория',
            'title' => 'Название',
            'description' => 'Описание',
            'price' => 'Цена',
            'producting_country' => 'Страна производитель',
            'year_of_issue' => 'Год выпуска',
            'model' => 'Модель',
            'tempImage' => 'Изображение',
            'in_stock' => 'В наличии',
            
        ];
    }

    public function beforeDelete()
    {
        $fileName = Yii::getAlias('@webroot') . '/images/' . $this->image;
        if(file_exists($fileName)){
            unlink($fileName);
        }
        
        return true;
    }

    /** 
    * Gets query for [[Category]]. 
    * 
    * @return \yii\db\ActiveQuery 
    */ 
   public function getCategory() 
   { 
       return $this->hasOne(Category::className(), ['id' => 'category_id']); 
   } 

   public static function getRecentFive()
   {
       return static::find()->orderBy('id desc')->limit(5)->all();
   } 
}
