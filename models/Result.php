<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "result".
 *
 * @property int $id
 * @property int|null $quiz_id
 * @property int|null $min_correct
 * @property int|null $correct_answer_count
 * @property int|null $number_of_questions
 * @property int|null $quiz_pass_date
 *
 * @property Quiz $quiz
 */
class Result extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'result';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['quiz_id', 'min_correct', 'correct_answer_count', 'number_of_questions', 'quiz_pass_date'], 'integer'],
            [['quiz_id'], 'exist', 'skipOnError' => true, 'targetClass' => Quiz::className(), 'targetAttribute' => ['quiz_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'quiz_id' => 'Quiz ID',
            'min_correct' => 'Min Correct',
            'correct_answer_count' => 'Correct Answer Count',
            'number_of_questions' => 'Number Of Questions',
            'quiz_pass_date' => 'Quiz Pass Date',
        ];
    }

    public function insertResult($data,$dataOfQuestionId){
        $array = [];
        //get id of Questions
        foreach ($dataOfQuestionId as $id) {
            $array[] = $id['questionId'];
        }
        $answers = Answer::find()->where(['question_id' => $array])->asArray()->all();
        $count = 0;
        $g = 0;

        //count how much selected answers is correct
        for ($i = 0; $i < count($answers); $i++) {
            if ($g < count($data) - 1) {
                if ($data[$g]['selectedAnswer'] === $answers[$i]['name']) {
                    if ($answers[$i]['is_correct'] == 1) {
                        $count++;
                    }
                    $g++;
                }
            }
        }
        $this->quiz_id=$data[count($data)-1]['quizId'];
        $this->min_correct=$data[count($data)-1]['minCorrect'];
        $this->correct_answer_count=$count;
        $this->number_of_questions=count($data)-1;
        $this->quiz_pass_date=time();
        $this->save();
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuiz()
    {
        return $this->hasOne(Quiz::className(), ['id' => 'quiz_id']);
    }
}
