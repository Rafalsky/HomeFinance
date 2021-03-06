<?php

/**
 *  This file is part of the HomeFinanceV2 project.
 *
 *  (c) Rafalsky.com <http://github.com/Rafalsky/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace common\models;

use \common\models\base\ReceiptProduct as BaseReceiptProduct;
use yii\db\Expression;

/**
 * This is the model class for table "receipt_product".
 *
 * @property integer $total_price
 */
class ReceiptProduct extends BaseReceiptProduct
{
    public function beforeValidate()
    {
        $this->updateTimestamps();
        return parent::beforeValidate();
    }

    private function updateTimestamps()
    {
        if ($this->isNewRecord) {
            $this->created_at = new Expression('NOW()');
        } else {
            $this->updated_at = new Expression('NOW()');
        }
    }
}
