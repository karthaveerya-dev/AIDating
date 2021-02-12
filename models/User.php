<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string|null $username
 * @property string|null $email
 * @property string|null $accessToken
 * @property string|null $tokenTime
 * @property string $password_hash
 * @property int $status
 * @property string|null $created_date
 * @property string|null $updated_date
 */
class User extends \yii\db\ActiveRecord
{

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    //const TOKEN_LIFE = Yii::$app->params['tokenLife'];
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
            [['created_date', 'updated_date', 'tokenTime'], 'safe'],
            [['username', 'email', 'accessToken', 'password_hash'], 'string', 'max' => 255],
            [['username','email'], 'unique'],
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
            'username' => 'Name',
            'email' => 'Email',
            'accessToken' => 'Token',
            'password_hash' => 'Password Hash',
            'status' => 'Status',
            'created_date' => 'Created Date',
            'updated_date' => 'Updated Date',
        ];
    }

    public static function findByUseremail($email)
    {
        //return static::findOne(['email' => $email, 'status' => self::STATUS_ACTIVE]);
        $users = self::find()->indexBy('id')->all();

        foreach ($users as $user) {
            if ($user['email'] === $email) {
                return $user;
            }
        }

        return null;
    }    

    /*--------------------------------*/

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        $users = self::find()->indexBy('id')->all();

        foreach ($users as $user) {
            if ($user['accessToken'] === $token) {
                return $user;
            }
        }

        return null;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        foreach (self::$users as $user) {
            if (strcasecmp($user['username'], $username) === 0) {
                return new static($user);
            }
        }

        return null;
    }

    public function generateToken(){
        //Generate a random string.
        $token = openssl_random_pseudo_bytes(16);
         
        //Convert the binary data into hexadecimal representation.
        $token = bin2hex($token);

        return $token;
    }

    public static function findById($user_id)
    {
        return static::findOne(['id' => $user_id]);        
    }  

}
