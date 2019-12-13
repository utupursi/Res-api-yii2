<?php

namespace app\controllers;


use app\models\Question;
use yii\rest\ActiveController;


class QuestionController extends ActiveController
{
    public $modelClass = 'app\models\Question';

}
