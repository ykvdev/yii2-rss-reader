<?php

namespace app\modules\user\models\forms;

use app\modules\common\models\db\FeedModel;
use yii\httpclient\Client;
use yii\httpclient\Exception;
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
            self::SCENARIO_SUBSCRIBE => ['user', 'url', 'title']
        ]);
    }

    public function fillFormByUrl() {
        $this->validateUrlExisting();
        $this->validateOrFindRssFeed();
    }

    private function validateUrlExisting() {
        if($this->hasErrors()) {
            return;
        }

        try {
            (new Client())->createRequest()->setUrl($this->url)->send();
        } catch(Exception $e) {
            $this->addError('url', 'Указанный URL адрес не существует');
        }
    }

    private function validateOrFindRssFeed() {
        if($this->hasErrors()) {
            return;
        }

        if(!$this->validateRssFeedAndInit()
        && !$this->findRssFeedAndInit()) {
            $this->addError('url', 'RSS канал по этой ссылке не найден');
        }
    }

    private function validateRssFeedAndInit() {
        try {
            $content = (new Client())->createRequest()->setUrl($this->url)->send()->getContent();
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
        try {
            $html = (new Client())->createRequest()->setUrl($this->url)->send()->getContent();
            $saw = new \nokogiri($html);
            $rssLinks = $saw->get('link[type="application/rss+xml"]')->toArray();
            if($rssLinks) {
                $this->url = $rssLinks[0]['href'];
                return $this->validateRssFeedAndInit();
            } else {
                return false;
            }
        } catch(\Exception $e) {
            return false;
        }
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
        && $this->save(false)
        && $this->saveIcon()) {
            return \Yii::$app->getResponse()->redirect(['/user/news/list', 'feed_id' => $this->id, 'page' => 1]);
        } else {
            return false;
        }
    }

    private function saveIcon() {
        try {
            $urlData = parse_url($this->url);
            $siteUrl = $urlData['scheme'] . '://' . $urlData['host'];
            $html = (new Client())->createRequest()->setUrl($siteUrl)->send()->getContent();
            $saw = new \nokogiri($html);
            $icons = $saw->get('link[rel="icon"]')->toArray();
            $iconUrl = null;
            if($icons) {
                $iconUrl = $icons[0]['href'];
                $iconUrl = strstr($iconUrl, 'http') === false ? $siteUrl . $iconUrl : $iconUrl;
            } else {
                $iconUrl = $siteUrl . '/favicon.ico';
            }
            
            $response = (new Client())->createRequest()->setUrl($iconUrl)->send();
            if($response->isOk) {
                file_put_contents(
                    FeedModel::getIconsPath() . '/' . $this->id . '.' . pathinfo($iconUrl, PATHINFO_EXTENSION),
                    $response->getContent()
                );
            }
        } catch(\Exception $e) {}

        return true;
    }
}