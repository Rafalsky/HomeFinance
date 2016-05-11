<?php
/*
 * This file is part of the HomeFinanceV2 project.
 *
 * (c) Rafalsky.com <http://github.com/Rafalsky/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
use \common\models\Receipt;

/**
 * @var Receipt $receipt
 */
?>

<div class="row">
    <div class="col-lg-12">
        <table id="receipts-list-table" class="table table-bordered table-striped navigation-table">
            <thead>
            <tr>
                <th><?= Yii::t('backend', 'ID'); ?></th>
                <th><?= Yii::t('backend', 'Shop'); ?></th>
                <th><?= Yii::t('backend', 'Date'); ?></th>
                <th><?= Yii::t('backend', 'Total Price');?></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach (Receipt::find()->all() as $receipt) : ?>
                <tr class="gradeX" data-url="<?= Yii::$app->urlManager->createUrl(['/wallet/transactions/receipt', ['id' => $receipt->id]]); ?>">
                    <td><?= $receipt->id; ?></td>
                    <td><?= $receipt->shop->name; ?></td>
                    <td><?= $receipt->date; ?></td>
                    <td><?= $receipt->getTotalPrice(); ?>&nbsp;zł</td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <div class="m-b-30">
            <a href="<?= Yii::$app->urlManager->createUrl(['/wallet/transactions/receipt/new']); ?>" class="btn btn-primary waves-effect waves-light">
                <?= Yii::t('backend', 'Add'); ?> <i class="fa fa-plus"></i>
            </a>
        </div>
    </div>
</div>