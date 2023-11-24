<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\RegistrationForm;
use app\models\ContactForm;
use app\models\Prices;
use app\models\User;
use app\models\Months;
use app\models\calculation;
use app\models\RawTypes;
use app\models\Tonnages;
use Codeception\Attribute\DataProvider;
use yii\data\ActiveDataProvider;

use yii\db\Query;

use yii\helpers\Url;


class CalculationController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['history'],
                'rules' => [
                    [
                        'actions' => ['history'],
                        'allow' => true,
                        'roles' => ['user'],
                    ],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays history.
     *
     * @return string
     */
    public function actionHistory()
    {
        $isAdmin = Yii::$app->authManager->getAssignment('admin', Yii::$app->user->id) !== null;

        if (!$isAdmin) {
            $dataProvider = new ActiveDataProvider([
                'query' => Calculation::find()->where(['user_id' => \Yii::$app->user->id]),
                'pagination' => [
                    'pageSize' => 20,
                ],
            ]);
            return $this->render('history', ['dataProvider' => $dataProvider]);
        }

        if ($isAdmin) {
            $dataProvider = new ActiveDataProvider([
                'query' => Calculation::find(),
                'pagination' => [
                    'pageSize' => 20,
                ],
            ]);
            return $this->render('history', ['dataProvider' => $dataProvider]);
        }
    }
    public function actionView($id)
    {
        $model = Calculation::findOne($id);
        return $this->render('view', ['model' => $model]);
    }

    public function actionDelete($id)
    {
        $model = Calculation::findOne($id);
        if ($model) {
            $model->delete();
            return $this->redirect(['calculation/history']);
        } else {
            throw new \yii\web\NotFoundHttpException('The requested page does not exist.');
        }
    }
}
