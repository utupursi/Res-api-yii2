<?php

namespace app\controllers;

use app\models\User;
use app\models\Users;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\rest\ActiveController;

class UserController extends ActiveController
{
    public $modelClass = 'app\models\Users';

//    public function behaviors()
//    {
//        $behaviours = parent::behaviors();
//        $behaviours['authenticator']['only'] = ['delete'];
//        $behaviours['authenticator']['authMethods'] = [
//            HttpBearerAuth::class
//        ];
//        return $behaviours;
//    }

//    public function actions()
//    {
//        $actions = parent::actions();
//        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
//        return $actions;
//    }

    public function prepareDataProvider()
    {
        return new ActiveDataProvider([
            'query' => Users::find()->andWhere(['id' => \Yii::$app->request->get('id')]),
        ]);
    }

    public function actionAllusers()
    {
        return Users::find()->all();

    }
    public function actionDeleteallusers(){
        return Users::deleteAll();
    }
}
