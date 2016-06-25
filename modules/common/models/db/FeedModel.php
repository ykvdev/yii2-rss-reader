<?php

namespace app\modules\common\models\db;

use app\components\ArPopulateTrait;
use Yii;
use yii\db\ActiveRecord;

/**
 * @property integer $id
 * @property integer $user
 * @property string $url
 * @property string $title
 * @property string $subscribed_at
 */
class FeedModel extends ActiveRecord
{
    use ArPopulateTrait;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'feeds';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['user', 'required'],
            ['user', 'integer'],
            ['user', 'exist', 'skipOnError' => true, 'targetClass' => UserModel::className(),
                'targetAttribute' => ['user' => 'id']],

            ['url', 'required'],
            ['url', 'url'],
            ['url', 'string', 'max' => 255],

            ['title', 'required'],
            ['title', 'string', 'max' => 255],

            ['subscribed_at', 'required'],
            ['subscribed_at', 'date', 'format' => 'php:Y-m-d H:i:s'],

            [['user', 'url'], 'unique', 'targetAttribute' => ['user', 'url'],
                'message' => 'Такой RSS канал уже существует'],
            [['user', 'title'], 'unique', 'targetAttribute' => ['user', 'title'],
                'message' => 'Такой RSS канал уже существует'],
        ];
    }

    /**
     * @return UserModel
     */
    public function getUserModel() {
        return $this->hasOne(UserModel::className(), ['id' => 'user'])->one();
    }

    /**
     * @return NewModel[]
     */
    public function getNewModels()
    {
        return $this->hasMany(NewModel::className(), ['feed' => 'id'])->all();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNewsQuery()
    {
        return $this->hasMany(NewModel::className(), ['feed' => 'id']);
    }
}
