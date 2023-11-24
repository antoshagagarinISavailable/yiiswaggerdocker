<?php

namespace app\controllers;

use app\models\User;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
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
     * Lists all User models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => User::find(),
            /*
            'pagination' => [
                'pageSize' => 50
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
            */
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
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
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new User();


        if ($this->request->isPost) {

            $model->auth_key = \Yii::$app->security->generateRandomString();
            if ($model->load($this->request->post())) {
                $post = $this->request->post()['User'];
                $model->username = $post['username'];
                $model->password_hash = \Yii::$app->security->generatePasswordHash($post['password_hash']);
                if ($model->save()) {
                    $auth = \Yii::$app->authManager;
                    $userRole = $auth->getRole('user');
                    $auth->assign($userRole, $model->getId());
                    \Yii::$app->session->setFlash('successMessage', 'userCreated');
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post())) {
            $role = $this->request->post()['role'];
            // dd(\Yii::$app->authManager->getRolesByUser($id));
            if (!\Yii::$app->authManager->getAssignment($role, $id)) {
                if ($id === '1') return $this->redirect(['index']);
                foreach (\Yii::$app->authManager->getRolesByUser($id) as $key => $value) {
                    if ($role === "guest") continue;
                    \Yii::$app->authManager->revoke(\Yii::$app->authManager->getRole($key), $id);
                };
                \Yii::$app->authManager->assign(\Yii::$app->authManager->getRole($role), $id);
            };
            // if (!\Yii::$app->authManager->getAssignment('admin', $id) && $role === 'user') {
            //     \Yii::$app->authManager->revoke(\Yii::$app->authManager->getRole($role), $id);
            // };
            $post = $this->request->post()['User'];
            $model->username = $post['username'];
            $model->email = $post['email'];
            if ($model->save()) {
                \Yii::$app->session->setFlash('successMessage', 'userUpdated');
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        // dd($id);
        if ($id === '1') return $this->redirect(['index']);
        if ($this->findModel($id)->delete()) {
            \Yii::$app->session->setFlash('successMessage', 'userDeleted');
            return $this->redirect(['index']);
        }
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
