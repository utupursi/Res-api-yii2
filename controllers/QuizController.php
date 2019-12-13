<?php

namespace app\controllers;
header("Access-Control-Allow-Headers: content-type");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: 'GET, POST, PUT, DELETE, OPTIONS'");

use app\models\Answer;
use app\models\Question;
use app\models\Quiz;
use app\models\User;
use app\models\Users;
use Yii;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;


class QuizController extends ActiveController
{
    public $modelClass = 'app\models\Quiz';

    public function actionGetlastquestion()
    {
        return Quiz::find()->orderBy(['id' => SORT_DESC])->one();
    }

    public function actionInsertdata()
    {
        $quiz = Yii::$app->request->post('arrayOfQuiz');
        $question = Yii::$app->request->post('arrayOfQuestions');
        $quizs = new Quiz();
        $questions = new Question();
        $quizs->insertData($quiz);
        $questions->insertData($question);
    }

    public function actionGetquestions()
    {
        $id = Yii::$app->request->get('id');
        return Question::find()->where(['quiz_id' => $id])->with('answers')->asArray()->all();
    }

    public function actionView($id)
    {
        return Quiz::findOne($id);
    }
}
