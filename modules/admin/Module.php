<?php

namespace app\modules\admin;

use app\models\User;
use yii\filters\AccessControl;

/**
 * admin module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\admin\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                // 'only' => ['special-callback'],
                'rules' => [
                    [
                        // 'actions' => ['special-callback'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            if (!\Yii::$app->user->isGuest) {
                                return \Yii::$app->user->identity->getIsAdmin();
                            }
                            return false;
                        }
                    ],
                    [
                        'denyCallback' => function ($rule, $action) {
                            \Yii::$app->getResponse()->redirect(\Yii::$app->homeUrl);
                        }
                    ]
                ],
            ],
        ];
    }
}
