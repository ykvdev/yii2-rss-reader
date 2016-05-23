<?php

namespace app\models\db;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property integer $id
 * @property string $email
 * @property string $password
 * @property string $registered_at
 * @property integer $activated
 *
 * @property FeedsModel[] $feeds
 */
class UsersModel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'password', 'registered_at'], 'required'],
            [['registered_at'], 'date', 'format' => 'php:Y-m-d H:i:s'],
            [['activated'], 'boolean'],
            [['email'], 'string', 'max' => 50],
            [['email'], 'email'],
            [['email'], 'unique', 'targetAttribute' => 'email', 'message' => 'The email has already been taken.'],
            [['password'], 'string', 'max' => 255],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFeeds()
    {
        return $this->hasMany(FeedsModel::className(), ['user' => 'id']);
    }

    public function sendMail($view, $subject) {
        self::sendMailTo($view, $subject, $this->email);
    }

    public static function sendMailTo($view, $subject, $recipientEmail, $recipientName = null) {
        // Set layout params
        if($recipientName) {
            \Yii::$app->mailer->getView()->params['name'] = $recipientName;
        }

        \Yii::$app->mailer->compose([
            'html' => 'views/' . $view . '-html',
            'text' => 'views/' . $view . '-text'
        ])->setTo($recipientName ? [$recipientEmail => $recipientName] : $recipientEmail)
            ->setSubject($subject)
            ->send();

        // Reset layout params
        if($recipientName) {
            \Yii::$app->mailer->getView()->params['name'] = null;
        }
    }
}
