<?php

/*
 * This file is part of the HomeFinanceV2 project.
 *
 * (c) Rafalsky.com <http://github.com/Rafalsky/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace app\models\base;

use app\models\User;
use \yii\db\ActiveRecord;

/**
 * This is the base-model class for table "token".
 *
 * @property integer $user_id
 * @property string $code
 * @property integer $created_at
 * @property integer $type
 *
 * @property \app\models\User $user
 * @property string $aliasModel
 */
abstract class Token extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%token}}';
    }

    /**
     * Alias name of table for crud viewsLists all Area models.
     * Change the alias name manual if needed later
     * @param bool $plural
     * @return string
     */
    public function getAliasModel($plural = false)
    {
        if ($plural) {
            return \Yii::t('app', 'Tokens');
        } else {
            return \Yii::t('app', 'Token');
        }
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'code', 'created_at', 'type'], 'required'],
            [['user_id', 'created_at', 'type'], 'integer'],
            [['code'], 'string', 'max' => 32],
            [
                ['user_id','code', 'type'],
                'unique',
                'targetAttribute' => ['user_id', 'code', 'type'],
                'message' => 'The combination of User ID, Code and Type has already been taken.'
            ],
            [
                ['user_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => User::className(),
                'targetAttribute' => ['user_id' => 'id']
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => \Yii::t('app', 'User ID'),
            'code' => \Yii::t('app', 'Code'),
            'created_at' => \Yii::t('app', 'Created At'),
            'type' => \Yii::t('app', 'Type'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeHints()
    {
        return array_merge(
            parent::attributeHints(),
            [
                'user_id' => \Yii::t('app', 'User Id'),
                'code' => \Yii::t('app', 'Code'),
                'created_at' => \Yii::t('app', 'Created At'),
                'type' => \Yii::t('app', 'Type'),
            ]
        );
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
