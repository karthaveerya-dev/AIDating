<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "profile".
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $location
 * @property int|null $distance_to
 * @property int|null $distance_from
 * @property string|null $sex
 * @property int|null $age_from
 * @property int|null $age_to
 *
 * @property User $user
 */
class Profile extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'profile';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'distance_to', 'distance_from', 'age_from', 'age_to'], 'integer'],
            [['sex'], 'string'],
            [['location'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['coord_lon', 'coord_lat'], 'double'],
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
            'location' => 'Location',
            'distance_to' => 'Distance To',
            'distance_from' => 'Distance From',
            'sex' => 'Sex',
            'age_from' => 'Age From',
            'age_to' => 'Age To',
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



    public static function findById($user_id)
    {
        return static::findOne(['user_id' => $user_id]);        
    }    

}
