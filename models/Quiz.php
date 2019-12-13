<?php

namespace app\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "quiz".
 *
 * @property int $id
 * @property string|null $subject
 * @property int|null $min_correct
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $max_question
 *
 * @property Question[] $questions
 */
class Quiz extends \yii\db\ActiveRecord
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
        return 'quiz';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['min_correct', 'created_at', 'updated_at', 'max_question'], 'integer'],
            [['subject'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'subject' => 'Subject',
            'min_correct' => 'Min Correct',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'max_question' => 'Max Question',
        ];
    }
    public function insertData($arrayOfQuiz){
        $this->subject=$arrayOfQuiz[0]['quizTitle'];
        $this->min_correct=$arrayOfQuiz[0]['minCorrect'];
        $this->max_question=$arrayOfQuiz[0]['maxQuestion'];
        if($this->save()){
            return true;
        }
        else{
            return false;
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestions()
    {
        return $this->hasMany(Question::className(), ['quiz_id' => 'id']);
    }

}
