<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\RegistrationForm;
use app\models\Prices;
use app\models\Calculation;

use yii\helpers\Url;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],

                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
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
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(['site/calc']);
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        if (Yii::$app->user->logout()) {
            $cookies = Yii::$app->response->cookies;
            $cookies->remove('hide_alert');
        };

        return $this->redirect(['site/login']);
    }

    public function actionCalc()
    {
        $cookies = Yii::$app->request->cookies;
        if (!$cookies->getValue('hide_alert', false)) {
            if (!Yii::$app->user->isGuest) {
                Yii::$app->session->setFlash('successMessage', 'authSuccess');
            }
        }


        $this->view->title = 'calc';
        $model = new Prices();
        $request = \Yii::$app->request;
        $data = '';
        $queue = '';

        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {

            $data = \Yii::$app->request->post();
            $calc_res = $model->getCalcRes();
            $all_months = $model->allMonths();
            $all_tonnages = $model->allTonnages();

            foreach ($data['Prices'] as $key => $value) {
                $queue .= $key . ' => ' . $value . "\n";
            }

            file_put_contents(Yii::getAlias('@runtime/queue.job'), $queue);
            if (\Yii::$app->request->isPjax) {
                $dataForTable = $model->dataForTable();
                $params = array(
                    'calc_res' => $calc_res,
                    'dataForTable' => $dataForTable,
                    'all_months' => $all_months,
                    'all_tonnages' => $all_tonnages
                );
                if (!Yii::$app->user->isGuest) {
                    Calculation::addCalculation($params);
                }

                return $this->render('calc', compact('model', 'calc_res', 'dataForTable'));
            }
            return $this->refresh();
        }

        return $this->render('calc', compact('model'));
    }

    public function actionRegister()
    {
        $model = new RegistrationForm();

        if ($model->load(Yii::$app->request->post()) && $model->register()) {
            return $this->redirect(['site/login']);
        }

        return $this->render('register', [
            'model' => $model,
        ]);
    }

    public function actionOop()
    {
        return $this->render('oop');
    }
    public function actionHideAlert()
    {
        Yii::$app->response->cookies->add(new \yii\web\Cookie([
            'name' => 'hide_alert',
            'value' => 'true',
        ]));
        return 'ок';
    }
}
