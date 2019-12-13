<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\bootstrap\Progress;

/**
 * This is the model class for table "question".
 *
 * @property int $id
 * @property int|null $quiz_id
 * @property string|null $name
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property Answer[] $answers
 * @property Quiz $quiz
 */
class Question extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return[
            TimestampBehavior::class,
        ];
    }
    public static function tableName()
    {
        return 'question';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['quiz_id', 'created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 255],
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
            'name' => 'Name',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
    public function getLastQuizId(){
        return Quiz::find()->orderBy(['id'=>SORT_DESC])->one();
    }
    public function getLastQuestion(){
        return Question::find()->orderBy(['id'=>SORT_DESC])->one();
    }
    public function insertData($questions)
    {
        $lastQuiz=$this->getLastQuizId();
        foreach($questions as $quest){
            $question=new Question();
            $question->quiz_id=$lastQuiz->id;
            $question->name=$quest['name'];
            $question->save();
            $this->insertAnswer($quest);

        }
    }

    public function insertAnswer($quest){
        $lastQuestion=$this->getLastQuestion();
        foreach ($quest['answers'] as $answer) {
            $answers = new Answer();
            $answers->question_id = $lastQuestion->id;
            $answers->is_correct = 0;
            $isCorrect=$answer['isTrue']=='true'?$isCorrect=1:$isCorrect=0;
            $answers->is_correct=$isCorrect;
            $answers->name = $answer['name'];
            $answers->save();
        }
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnswers()
    {
        return $this->hasMany(Answer::className(), ['question_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuiz()
    {
        return $this->hasOne(Quiz::className(), ['id' => 'quiz_id']);
    }
}
