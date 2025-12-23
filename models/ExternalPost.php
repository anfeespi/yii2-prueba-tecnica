<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "external_posts".
 *
 * @property int $id
 * @property int $external_id
 * @property int|null $user_id
 * @property string|null $title
 * @property string|null $body
 * @property string|null $payload
 * @property string|null $hash
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class ExternalPost extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'external_posts';
    }

    public function behaviors()
    {
        return [TimestampBehavior::class];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'title', 'body', 'payload', 'hash', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['external_id'], 'required'],
            [['external_id', 'user_id', 'created_at', 'updated_at'], 'integer'],
            [['body', 'payload'], 'string'],
            [['title', 'hash'], 'string', 'max' => 255],
            [['external_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'external_id' => 'External ID',
            'user_id' => 'User ID',
            'title' => 'Title',
            'body' => 'Body',
            'payload' => 'Payload',
            'hash' => 'Hash',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

}
