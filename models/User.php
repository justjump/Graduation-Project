<?php

namespace app\models;
use Yii;

/**
 * This is the model class for table "tbl_user".
 *
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $name
 * @property integer $gender
 * @property string $phone
 * @property string $province
 * @property string $city
 * @property string $county
 * @property string $avatar
 * @property string $url
 * @property string $desc
 * @property integer $created
 * @property integer $updated
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'email' ,'password', 'name', 'gender', 'phone', 'province', 'url', 'desc'], 'required'],
            [['gender', 'created', 'updated'], 'integer'],
            [['desc'], 'string'],
            [['username', 'password', 'name', 'phone', 'province', 'county', 'city', 'avatar'], 'string', 'max' => 99],
            [['url'], 'string', 'max' => 999]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => '邮件',
            'username' => '用户名',
            'password' => '密码',
            'name' => '名字',
            'gender' => '性别',
            'phone' => '电话',
            'province' => '省份',
            'county' => '地区',
            'city' => '城市',
            'avatar' => '头像',
            'url' => '链接',
            'desc' => '描述',
            'created' => 'Created',
            'updated' => 'Updated',
        ];
    }

    public function beforeSave($insert) 
    {   
        if (parent::beforeSave($insert)) 
        {
            $this->updated = time();
            if ($insert) 
            {
                $this->created = $this->updated;
            }  
            return true;
        } 
        else 
        {
            return false;
        } 
    }     


    public static function findIdentity($id)
    {
        return self::find()->where(['id' => $id])->one();
    }


    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }    


    public static function findByUsername($username)
    {
        return self::find()->where(' LOWER(username) = :username', [':username' => strtolower($username)])->one();
    }   


    public function getId()
    {
        return $this->id;
    }


    public function getAuthKey()
    {
        return $this->id;
    }


    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }


    public function encodePassword($password)
    {
        return md5(md5($password));
    }


    public function validatePassword($password)
    {
        return $this->encodePassword($password) === $this->password;
    } 

}
