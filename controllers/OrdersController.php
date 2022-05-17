<?php

namespace app\controllers;

use app\models\Cart;
use app\models\LoginForm;
use app\models\Orderitems;
use app\models\Orders;
use app\models\OrdersSearch;
use app\models\Status;
use Yii;
use yii\data\ArrayDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\bootstrap4\ActiveForm;

/**
 * OrdersController implements the CRUD actions for Orders model.
 */
class OrdersController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Orders models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new OrdersSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $statusArray = Status::getArray();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'statusArray' => $statusArray,
        ]);
    }

    /**
     * Displays a single Orders model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Orders model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {

        if ($cart = Cart::getCart()) {
            $dataProvider = new ArrayDataProvider(['allModels' => $cart['products'], 'pagination' => ['pageSize' => 4]]);
            $login = new LoginForm();
            $login->login = Yii::$app->user->identity;

            if (Yii::$app->request->isAjax && $login->load(Yii::$app->request->post())) {
                // $login->default = false;
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($login);
            }

            if (Yii::$app->request->isPost && $login->load(Yii::$app->request->post()) && $login->validate()) {
                $db = Yii::$app->db;
                $transaction = $db->beginTransaction();

                $order = new Orders();

                if ($order->orderCreate($cart)) {
                    if (Orderitems::orderItemsCreate($cart, $order->id)) {
                        $transaction->commit();
                        Yii::$app->session->remove('cart');

                        Yii::$app->session->setFlash('success', 'Заказ оформлен');
                        return $this->redirect(['/orders']);
                    }
                }

                $transaction->rollBack();

                Yii::$app->session->setFlash('error', 'Ошибка при оформлении заказа');
            }

            return $this->render('create', compact('login', 'cart', 'dataProvider'));
        }

        $this->goHome();
    }

    /**
     * Updates an existing Orders model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Orders model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Orders model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Orders the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Orders::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
