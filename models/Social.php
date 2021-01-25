<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_social".
 *
 * @property int $id
 * @property int $user_id
 * @property string $social_net
 * @property string $key
 *
 * @property User $user
 */
class Social extends \yii\db\ActiveRecord
{

    const FACEBOOK = 'facebook';
    const GOOGLE = 'google';


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_social';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'social_net', 'key'], 'required'],
            [['user_id'], 'integer'],
            [['social_net', 'key'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            ['key', 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'social_net' => 'Social Net',
            'key' => 'Key',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public static function findByKey($key)
    {
        return static::findOne(['key' => $key]);
    } 


}
