<?php

namespace app\modules\user\models\forms;

use app\modules\common\models\db\FeedModel;
use yii\web\Response;

class SubscribeFeedForm extends FeedModel
{
    const SCENARIO_SUBSCRIBE = 'subscribe';

    public function init() {
        parent::init();
        $this->scenario = self::SCENARIO_SUBSCRIBE;
    }

    public function scenarios() {
        return array_merge(parent::scenarios(), [
            self::SCENARIO_SUBSCRIBE => ['url']
        ]);
    }

    public function rules() {
        return array_merge(parent::rules(), [
            ['url', 'validateUrlExisting'],
            ['url', 'validateOrFindRssFeed']
        ]);
    }

    public function validateUrlExisting($attribute, $params) {
        if($this->hasErrors()) {
            return;
        }

        $ch = curl_init($this->url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if($httpCode != 200) {
            $this->addError($attribute, 'Указанный URL адрес не существует');
        }
    }

    public function validateOrFindRssFeed($attribute, $params) {
        if(!$this->hasErrors()
        && !$this->validateRssFeedAndInit()
        && !$this->findRssFeedAndInit()) {
            $this->addError($attribute, 'RSS канал по этой ссылке не найден');
        }
    }

    private function validateRssFeedAndInit() {
        $content = file_get_contents($this->url);
        try {
            $rss = new \SimpleXMLElement($content);
            if(isset($rss->channel->item)
            && $rss->channel->item->count() > 0
            && isset($rss->channel->title)) {
                $this->title = (string)$rss->channel->title;
                return true;
            } else {
                return false;
            }
        }
        catch(\Exception $e){
            return false;
        }
    }

    private function findRssFeedAndInit() {
        if($html = file_get_contents($this->url)) {
            $saw = new \nokogiri($html);
            $rssLinks = $saw->get('link[type="application/rss+xml"]')->toArray();
            if($rssLinks) {
                $this->url = $rssLinks[0]['href'];
                return $this->validateRssFeedAndInit();
            }
        }

        return false;
    }

    public function attributeLabels() {
        return array_merge(parent::attributeLabels(), [
            'url' => 'URL сайта или RSS канала'
        ]);
    }

    /**
     * @return Response|bool
     */
    public function subscribe() {
        if($this->validate()
        && $this->save(false)) {
            return \Yii::$app->getResponse()->redirect(['/user/news/list', 'feed_id' => $this->id, 'page' => 1]);
        } else {
            return false;
        }
    }
}