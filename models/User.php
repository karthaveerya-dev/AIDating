<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $email
 * @property string|null $token
 * @property string $password_hash
 * @property int $status
 * @property string|null $created_date
 * @property string|null $updated_date
 */
class User extends \yii\db\ActiveRecord
{

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['password_hash'], 'required'],
            [['status'], 'integer'],
            [['created_date', 'updated_date'], 'safe'],
            [['name', 'email', 'token', 'password_hash'], 'string', 'max' => 255],
            [['name','email'], 'unique'],
        ];
    }

    public function beforeSave($insert) {
        parent::beforeSave($insert);

        if ($this->isNewRecord) {
            $this->created_date = date('Y-m-d H:i:s');
        }

        $this->updated_date = date('Y-m-d H:i:s');

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'email' => 'Email',
            'token' => 'Token',
            'password_hash' => 'Password Hash',
            'status' => 'Status',
            'created_date' => 'Created Date',
            'updated_date' => 'Updated Date',
        ];
    }

    public static function findByUseremail($email)
    {
        return static::findOne(['email' => $email, 'status' => self::STATUS_ACTIVE]);
    }    

    

}
