<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Prices;
use app\models\Months;
use app\models\RawTypes;
use app\models\Tonnages;
use yii\db\Query;

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
            return $this->goBack();
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
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionCalc()
    {
        $model = new Prices();
        $request = \Yii::$app->request;
        $data = '';
        $queue = '';
        $months = Months::getListForSelect();
        $raw_types = RawTypes::getListForSelect();
        $tonnages = Tonnages::getListForSelect();

        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            $data = \Yii::$app->request->post();
            foreach ($data['Prices'] as $key => $value) {
                $queue .= $key . ' => ' . $value . "\n";
            }
            file_put_contents(Yii::getAlias('@runtime/queue.job'), $queue);
            if (\Yii::$app->request->isPjax) {
                $cacl_query = new Query();
                $res = $cacl_query->select(['raw_types.name as raw', 'months.name as month', 'price', 'tonnages.value as tonnage'])
                    ->from('months')
                    ->innerJoin('prices', 'months.id = prices.month_id')
                    ->innerJoin('tonnages', 'tonnages.id = prices.tonnage_id')
                    ->innerJoin('raw_types', 'raw_types.id = prices.raw_type_id')
                    ->where(['raw_type_id' => $model->raw_type_id])
                    ->andWhere(['tonnage_id' => $model->tonnage_id])
                    ->andWhere(['month_id' => $model->month_id])
                    ->orderBy(['tonnages.value' => SORT_ASC, 'months.id' => SORT_ASC])
                    ->all();
                $table_query = new Query();
                $dataForTable = $table_query->select(['price', 'months.name', 'tonnages.value'])
                    ->from('months')
                    ->innerJoin('prices', 'months.id = prices.month_id')
                    ->innerJoin('tonnages', 'tonnages.id = prices.tonnage_id')
                    ->innerJoin('raw_types', 'raw_types.id = prices.raw_type_id')
                    ->where(['raw_type_id' => $model->raw_type_id])
                    ->orderBy(['tonnages.value' => SORT_ASC, 'months.id' => SORT_ASC])
                    ->all();


                return $this->render('Calc', compact('model', 'data', 'queue', 'months', 'raw_types', 'tonnages', 'res', 'dataForTable'));
            } else {
                return $this->refresh();
            }
        }

        return $this->render('Calc', compact('model', 'data', 'queue', 'months', 'raw_types', 'tonnages'));
    }
    public function actionOop()
    {
        return $this->render('oop');
    }
}
