<?php

namespace app\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\Url;
use yii\web\Link;
use yii\web\Linkable;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $surname
 * @property string|null $age
 */
class Users extends \yii\db\ActiveRecord implements Linkable
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return[
            TimestampBehavior::class,
            [
                'class'=>BlameableBehavior::class,
                'createdByAttribute'=>false,
                'updatedByAttribute'=>false,

            ]
        ];
    }

    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'surname', 'age'], 'string', 'max' => 255],
            [['age'],'required']
        ];
    }

    public function fields()
    {
        return [
            'id',
            'name',
            'surname',
            'created_at',
            'updated_at'
        ];
    }

    public function extraFields()
    {
        return ['surname'];
    }

    public function getLinks()
    {
        return [
            Link::REL_SELF => Url::to(['user/view', 'id' => $this->id], true),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'surname' => 'Surname',
            'age' => 'Age',
        ];
    }
}
