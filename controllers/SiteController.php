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
use app\models\Calculation;
use app\models\User;
use app\models\Months;
use app\models\RawTypes;
use app\models\Tonnages;
use yii\db\Query;

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

    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            if (Yii::$app->user->can('admin')) {
                Yii::$app->layout = 'adminLayout';
            }
            return true;
        } else {
            return false;
        }
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
        Yii::$app->user->logout();

        return $this->redirect(['site/login']);
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
        $this->view->title = 'calc';
        $model = new Prices();
        $request = \Yii::$app->request;
        $data = '';
        $queue = '';

        if (!Yii::$app->user->isGuest) {
            Yii::$app->session->setFlash('success', 'Здравствуйте, ' . Yii::$app->user->identity->username . ', вы авторизовались в системе расчета стоимости доставки. Теперь все ваши расчеты будут сохранены для последующего просмотра в журнале расчетов. <a href="' . Url::to(['calculation/history']) . '">Журнал расчетов</a>');
        }

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
                if (!Yii::$app->user->isGuest) {
                    // dump($calc_res);
                    $calculation = new Calculation();
                    $calculation->table_data = json_encode($dataForTable);
                    $calculation->user = User::findOne(Yii::$app->user->id)->username;
                    $calculation->user_id = Yii::$app->user->id;
                    $calculation->month = $calc_res['month'];
                    $calculation->type = $calc_res['raw'];
                    $calculation->tonnage = $calc_res['tonnage'];
                    $calculation->result = $calc_res['price'];
                    $calculation->all_months = json_encode($all_months);
                    $calculation->all_tonnages = json_encode($all_tonnages);
                    $calculation->save();
                }

                return $this->render('Calc', compact('model', 'calc_res', 'dataForTable'));
            } else {
                return $this->refresh();
            }
        }

        return $this->render('Calc', compact('model'));
    }

    // public function actionRegister()
    // {
    //     $model = new User();

    //     if ($model->load(Yii::$app->request->post()) && $model->validate()) {
    //         $model->password = Yii::$app->security->generatePasswordHash($model->password);
    //         if ($model->save()) {
    //             Yii::$app->session->setFlash('success', 'Вы успешно зарегистрировались!');
    //             return $this->redirect(['site/login']);
    //             $auth = Yii::$app->authManager;
    //             $userRole = $auth->getRole('user');
    //             $auth->assign($userRole, $model->getId());
    //         }
    //     }

    //     return $this->render('register', [
    //         'model' => $model,
    //     ]);
    // }
    public function actionRegister()
    {
        $model = new RegistrationForm();

        if ($model->load(Yii::$app->request->post()) && $model->register()) {
            // перенаправляем пользователя на страницу успешной регистрации
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
}
