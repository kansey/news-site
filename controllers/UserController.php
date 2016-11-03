<?php

namespace app\controllers;

use Yii;
use app\models\User;
use app\models\UserSearch;
use app\models\CreateUser;
use app\models\ConfirmForm;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    /**
     * @inheritdoc
     */


    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'confirm'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['confirm'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => false,
                        'actions' => ['index', 'view', 'create', 'update'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                    [
                        'allow' => false,
                        'roles' => ['guest'],
                    ],
                    [
                        'allow' => false,
                        'roles' => ['user'],
                    ],
                    [
                        'allow' => false,
                        'roles' => ['moder'],
                    ],
                ],
            ],/*
            'deny' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => false,
                        'actions' => ['view', 'create', 'update'],
                        'roles' => ['?'],
                    ],

                    [
                        'allow' => true,
                        'actions' => ['index', 'view', 'create', 'update'],
                        'roles' => ['guest', 'user', 'moder'],
                    ],
                ],
            ]*/
        ];
    }


    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
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
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CreateUser();

        if ($model->load(Yii::$app->request->post())) {

            if ($user = $model->createUser()) {

                $email = Yii::$app->mailer->compose()
                    ->setFrom([\Yii::$app->params['adminEmail'] => 'Authorization for' . \Yii::$app->name])
                    ->setTo($user->email)
                    ->setSubject('Authorization')
                    ->setHtmlBody("Click this link ".\yii\helpers\Html::a('confirm', Yii::$app->urlManager->createAbsoluteUrl(['user/confirm','token'=> $user->token])) .'to be authorized')
                    ->send();

                if ($email) {
                    Yii::$app->getSession()->setFlash('success','Email send!');
                } else {
                    Yii::$app->getSession()->setFlash('warning','Failed, Email not send');
                }
            }
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionConfirm($token)
    {
        $modelConfirm = new ConfirmForm();

        if ($modelConfirm->load(Yii::$app->request->post()) && $modelConfirm->validate()) {
            $user = User::find()->where(['token'=> $token])->one();

            if (!empty($user)) {
                $user->status = 'admin';
                $user->setPassword($modelConfirm->password);
                $user->save();
                return header("Location: ". \Yii::$app->urlManager->createUrl("site/login"));
            }
        }
        return $this->render('confirm', [
            'model' => $modelConfirm,
        ]);
}

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

            $model->setPassword($_POST['User']['password']);

            if ($model->save()) {

                $email = Yii::$app->mailer->compose()
                        ->setFrom([\Yii::$app->params['adminEmail'] => 'Your send new password for' . \Yii::$app->name])
                        ->setTo($model->email)
                        ->setSubject('You have changed your password')
                        ->setTextBody("Your new password ". $_POST['User']['password'])
                        ->send();

                if ($email) {
                    return $this->redirect(['view', 'id' => $model->id]);
                } else {
                    throw new NotFoundHttpException('warning','Failed, wrong email user or admin');
                }
            }
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
