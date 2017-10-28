<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Invoice $invoice
 */

?>
<style>
    .form-horizontal .control-label {
        padding-top: 11px;
    }
</style>
<div class="text-center">
    <span class="thumbnail"><?= $this->Image->display($invoice->scan, 'lg') ?></span>
</div>
<?= $this->Form->create($invoice, ['align' => [
    'xs' => [
        'left' => 5,
        'middle' => 7,
        //'right' => 12
    ],
    'sm' => [
        'left' => 4,
        'middle' => 6,
        'right' => 12
    ]
]]) ?>
    <?= $this->Form->control('supplier_id') ?>
    <?= $this->Form->control('number', ['label' => __('Invoice #')]) ?>
    <?= $this->Form->control('invoice_date', ['label' => __('Invoice Date')]) ?>
    <?= $this->Form->control('due', ['label' => __('Invoice Due')]) ?>
    <div class="form-group number required">
        <label class="control-label col-xs-5 col-sm-4" for="amount"><?= __('Amount') ?></label>
        <div class="col-xs-7 col-sm-6">
            <div class="input-group">
                <span class="input-group-addon">$</span>
                <?= $this->Form->text('amount', ['type' => 'number', 'step' => '0.01', 'class' => 'form-control', 'required']) ?>
            </div>
        </div>
    </div>
    <?php if ($invoice->is_approved): ?>
        <?= $this->Form->control('mapped_account', ['options' => ['Xero - Electricity']]) ?>
        <h3><?= __('Payment Request') ?></h3>
        <div class="row" style="margin-bottom:10px;">
            <label class="control-label col-xs-12 col-sm-4"><?= __('When') ?></label>
            <div class="col-xs-12 col-sm-8">
                <div class="btn-group btn-group-justified" role="group">
                    <?= $this->Form->radio('payment_delay', ['-3' => '-3'], ['label' => false, 'hiddenField' => false]) ?><label for="payment-delay--3" class="btn btn-default" role="button"><?= __('3 days early') ?></label>
                    <?= $this->Form->radio('payment_delay', ['0' => '0'], ['label' => false, 'hiddenField' => false, 'default' => '0']) ?><label for="payment-delay-0" class="btn btn-default" role="button"><?= __('On-time') ?></label>
                    <?= $this->Form->radio('payment_delay', ['+3' => '+3'], ['label' => false, 'hiddenField' => false]) ?><label for="payment-delay-+3" class="btn btn-default" role="button"><?= __('3 days later') ?></label>
                </div>
            </div>
        </div>
        <div class="row" style="margin-bottom:20px;">
            <label class="control-label col-xs-12 col-sm-4"><?= __('Which') ?></label>
            <div class="col-xs-12 col-sm-8">
                <div class="btn-group btn-group-justified" role="group">
                    <?= $this->Form->radio('payment_account_token', ['personal' => 'personal'], ['label' => false, 'hiddenField' => false]) ?><label for="payment-account-token-personal" class="btn btn-default" role="button"><?= __('Personal') ?></label>
                    <?= $this->Form->radio('payment_account_token', ['operating' => 'operating'], ['label' => false, 'hiddenField' => false, 'default' => 'operating']) ?><label for="payment-account-token-operating" class="btn btn-default" role="button"><?= __('Operating') ?></label>
                    <?= $this->Form->radio('payment_account_token', ['parent' => 'parent'], ['label' => false, 'hiddenField' => false]) ?><label for="payment-account-token-parent" class="btn btn-default" role="button"><?= __('Parent') ?></label>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <div class="form-group text-center">
        <?= $this->Form->button(__('Submit'), ['class' => 'btn-primary']) ?>
    </div>
<?= $this->Form->end() ?>
