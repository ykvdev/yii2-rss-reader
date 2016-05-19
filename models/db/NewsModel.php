<?php

namespace app\models\db;

use Yii;

/**
 * This is the model class for table "news".
 *
 * @property integer $id
 * @property integer $feed
 * @property string $published_at
 * @property string $title
 * @property string $short_text
 * @property string $external_uri
 * @property integer $read
 *
 * @property FeedsModel $feed
 */
class NewsModel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'news';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['feed', 'published_at', 'title', 'short_text', 'external_uri'], 'required'],
            [['feed'], 'integer'],
            [['read'], 'boolean'],
            [['published_at'], 'date', 'format' => 'php:Y-m-d H:i:s'],
            [['title', 'short_text', 'external_uri'], 'string', 'max' => 255],
            [['feed', 'title'], 'unique', 'targetAttribute' => ['feed', 'title'], 'message' => 'The combination of feed and title has already been taken.'],
            [['feed', 'external_uri'], 'unique', 'targetAttribute' => ['feed', 'external_uri'], 'message' => 'The combination of feed and external_uri has already been taken.'],
            [['feed'], 'exist', 'skipOnError' => true, 'targetClass' => FeedsModel::className(), 'targetAttribute' => ['feed' => 'id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFeed()
    {
        return $this->hasOne(FeedsModel::className(), ['id' => 'feed']);
    }
}
