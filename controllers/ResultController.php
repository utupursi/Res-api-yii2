<?php

namespace app\controllers;
header("Access-Control-Allow-Headers: content-type");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: 'GET, POST, PUT, DELETE, OPTIONS'");

use app\models\Answer;
use app\models\Question;
use app\models\Quiz;
use app\models\Result;
use app\models\User;
use app\models\Users;
use Yii;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;


class ResultController extends ActiveController
{
    public $modelClass = 'app\models\Result';


    public function actionInsertdata()
    {
        $dataOfPassedQuiz = Yii::$app->request->post('arrayOfAnswers');
        $dataOfQuestionsId = Yii::$app->request->post('arrayOfQuestions');
        $res = new Result();
        $res->insertResult($dataOfPassedQuiz, $dataOfQuestionsId);
    }

    public function actionGetlastdata()
    {
        return Result::find()->orderBy(['id' => SORT_DESC])->one();
    }

    public function actionResult()
    {
        $result = Result::find()->with('quiz')->asArray()->all();
        $array = [];
        $i = 0;
        foreach ($result as $res) {
            $date = Yii::$app->formatter->asDatetime($res['quiz_pass_date']);
            $array[$i]['id'] = $res['id'];
            $array[$i]['quiz_id'] = $res['quiz_id'];
            $array[$i]['min_correct'] = $res['min_correct'];
            $array[$i]['correct_answer_count'] = $res['correct_answer_count'];
            $array[$i]['number_of_questions'] = $res['number_of_questions'];
            $array[$i]['quiz_pass_date'] = $date;
            $array[$i]['quiz'] = $res['quiz'];
            $i++;
        }
        return $array;
    }
}
