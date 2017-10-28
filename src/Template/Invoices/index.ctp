<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Invoice[]|\Cake\Collection\CollectionInterface $invoices
 */

$this->assign('title', __('Invoices'));
?>
<ul class="nav nav-pills" style="margin-bottom:10px;">
    <li><?= $this->Html->link(__('Scan'), ['action' => 'add']) ?></li>
    <li><?= $this->Html->link(__('Suppliers'), ['controller' => 'Suppliers', 'action' => 'index']) ?></li>
    <li><?= $this->Html->link(__('Payments'), ['controller' => 'Payments', 'action' => 'index']) ?></li>
</ul>
<div class="invoices index large-9 medium-8 columns content">
    <?php foreach ($invoices as $invoice): ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <?= $this->Html->link(__('#{0}, {1}', $invoice->number, $invoice->supplier->name), ['action' => 'view', $invoice->id]) ?>
                <strong class="pull-right"><?= $this->Number->currency($invoice->amount) ?></strong>
            </div>
            <div class="panel-body">
                <div class="pull-right">
                <?= $this->Html->link($this->Image->display($invoice->scan, 'sm'), $this->Image->imageUrl($invoice->scan, 'lg'), ['escape' => false, 'class' => 'thumbnail', 'target' => '_blank', 'style' => 'max-width:80px']) ?>
                </div>
                <strong><?= __('Date:') ?></strong> <?= $invoice->invoice_date->nice() ?><br />
                <strong><?= __('Due:') ?></strong> <?= $invoice->invoice_date->nice() ?><br />
                <strong><?= __('Mapped Account:') ?></strong> <?= h($invoice->mapped_account) ?><br /><br />
                <strong><?= __('Approved:') ?></strong> <?php if ($invoice->is_approved): ?><span class="label label-success"><?= __('Yes') ?></span><?php else: ?><span class="label label-danger"><?= __('No') ?></span><?php endif; ?><br />
                <strong><?= __('Paid:') ?></strong> <?php if ($invoice->is_paid): ?><span class="label label-success"><?= __('Yes') ?></span><?php else: ?><span class="label label-danger"><?= __('No') ?></span><?php endif; ?><br />
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?= $this->element('pagination') ?>
