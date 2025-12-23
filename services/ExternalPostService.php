<?php

namespace app\services;

use app\models\ExternalPost;
use yii\httpclient\Client;
use yii\helpers\Json;

class ExternalPostService
{
    private $url = 'https://jsonplaceholder.typicode.com/posts';

    public function syncPosts()
    {
        // 1. Consumir la API
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('GET')
            ->setUrl($this->url)
            ->send();

        if (!$response->isOk) {
            throw new \Exception('Error al conectar con la API externa.');
        }

        $posts = $response->getData();

        $stats = ['created' => 0, 'updated' => 0, 'skipped' => 0];

        foreach ($posts as $postData) {
            $this->processPost($postData, $stats);
        }

        return $stats;
    }

    private function processPost($data, &$stats)
    {
        $externalId = $data['id'];
        $model = ExternalPost::findOne(['external_id' => $externalId]);

        $payloadJson = Json::encode($data);
        $newHash = md5($payloadJson);

        if (!$model) {
            $model = new ExternalPost();
            $model->external_id = $externalId;
            $this->fillModel($model, $data, $payloadJson, $newHash);
            
            if ($model->save()) {
                $stats['created']++;
            }
        } else {
            if ($model->hash !== $newHash) {
                $this->fillModel($model, $data, $payloadJson, $newHash);
                if ($model->save()) {
                    $stats['updated']++;
                }
            } else {
                $stats['skipped']++;
            }
        }
    }

    private function fillModel($model, $data, $payload, $hash)
    {
        $model->user_id = $data['userId'];
        $model->title = $data['title'];
        $model->body = $data['body'];
        $model->payload = $payload;
        $model->hash = $hash;
    }
}