<?php

/*
 *  This file is part of the HomeFinanceV2 project.
 *
 *  (c) Rafalsky.com <http://github.com/Rafalsky/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace wallet\models;

use cheatsheet\Time;
use common\models\User;
use yii\base\Model;
use yii\web\ForbiddenHttpException;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;

    private $user = false;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => \Yii::t('wallet', 'Username'),
            'password' => \Yii::t('wallet', 'Password'),
            'rememberMe' => \Yii::t('wallet', 'Remember Me')
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     */
    public function validatePassword()
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError('password', \Yii::t('wallet', 'Incorrect username or password.'));
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     * @throws \yii\base\InvalidParamException
     * @throws ForbiddenHttpException
     */
    public function login()
    {
        if (!$this->validate()) {
            return false;
        }
        $duration = $this->rememberMe ? Time::SECONDS_IN_A_MONTH : 0;
        if (\Yii::$app->user->login($this->getUser(), $duration)) {
            return true;
        }

        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->user === false) {
            $this->user = User::find()
                ->andWhere(['or', ['username' => $this->username], ['email' => $this->username]])
                ->one();
        }

        return $this->user;
    }
}
