<?php

namespace app\modules\common\models\db;

use app\components\ArPopulateTrait;
use Yii;
use yii\db\ActiveRecord;

/**
 * @property integer $id
 * @property integer $feed
 * @property string $published_at
 * @property string $title
 * @property string $short_text
 * @property string $external_uri
 * @property integer $read
 */
class NewModel extends ActiveRecord
{
    use ArPopulateTrait;

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
            ['feed', 'required'],
            ['feed', 'integer'],
            ['feed', 'exist', 'skipOnError' => true, 'targetClass' => FeedModel::className(),
                'targetAttribute' => ['feed' => 'id']],

            ['published_at', 'required'],
            ['published_at', 'date', 'format' => 'php:Y-m-d H:i:s'],

            ['title', 'required'],
            ['title', 'string', 'max' => 255],

            ['short_text', 'required'],
            ['short_text', 'string', 'max' => 255],

            ['external_uri', 'required'],
            ['external_uri', 'string', 'max' => 255],

            ['read', 'boolean'],

            [['feed', 'title'], 'unique', 'targetAttribute' => ['feed', 'title'],
                'message' => 'Такая новость уже есть в этом RSS канале'],
            [['feed', 'external_uri'], 'unique', 'targetAttribute' => ['feed', 'external_uri'],
                'message' => 'Такая новость уже есть в этом RSS канале'],
        ];
    }

    /**
     * @return FeedModel
     */
    public function getFeedModel()
    {
        return $this->hasOne(FeedModel::className(), ['id' => 'feed'])->one();
    }
}
