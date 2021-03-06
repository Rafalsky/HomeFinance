<?php

/*
 * This file is part of the HomeFinanceV2 project.
 *
 * (c) Rafalsky.com <http://github.com/Rafalsky/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace wallet\controllers;

use common\models\Wallet;

class ManageController extends DefaultModuleController
{
    public function actionFirst()
    {
        $this->layout = 'base';
        $this->view->title = \Yii::t('wallet', 'Create first wallet');
        $model = new Wallet(['scenario' => Wallet::SCENARIO_CREATE]);
        if (\Yii::$app->request->isPost) {
            $model->attributes = \Yii::$app->request->post('Wallet');
            if ($model->save()) {
                \Yii::$app->session->setFlash('success', \Yii::t('common', 'Wallet successfully saved'));
                $this->redirect('/wallet');
            } else {
                \Yii::$app->session->setFlash('error', \Yii::t('common', 'Please fix errors below'));
            }
        }
        return $this->render('first', [
            'model' => $model
        ]);
    }

    public function actionCreate()
    {
        $this->view->title = \Yii::t('wallet', 'Create new wallet');
        return $this->render('create');
    }

    protected function isWalletRequired()
    {
        return $this->action->id !== 'first';
    }
}
