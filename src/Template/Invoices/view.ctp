<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Invoice $invoice
 */
?>

<ul class="nav nav-pills" style="margin-bottom:10px;">
    <li><?= $this->Html->link(__('Edit Invoice'), ['action' => 'edit', $invoice->id]) ?> </li>
    <li><?= $this->Form->postLink(__('Delete Invoice'), ['action' => 'delete', $invoice->id], ['confirm' => __('Are you sure you want to delete # {0}?', $invoice->id)]) ?> </li>
    <li><?= $this->Html->link(__('List Invoices'), ['action' => 'index']) ?> </li>
    <li><?= $this->Html->link(__('New Invoice'), ['action' => 'add']) ?> </li>
</ul>
<div class="panel panel-default">
    <div class="panel-heading">
        <?= $this->Html->link(__('#{0}, {1}', $invoice->number, $invoice->supplier->name), ['action' => 'view', $invoice->id]) ?>
        <strong class="pull-right"><?= $this->Number->currency($invoice->amount) ?></strong>
    </div>
    <div class="panel-body">
        <table class="table table-striped">
            <tbody>
            <tr>
                <th style="width:150px"><?= __('Supplier') ?></th>
                <td><?= $invoice->supplier->name ?></td>
            </tr>
            <tr>
                <th><?= __('Invoice Date') ?></th>
                <td><?= $invoice->invoice_date->nice() ?></td>
            </tr>
            <tr>
                <th><?= __('Invoice Due') ?></th>
                <td><?= $invoice->due->nice() ?></td>
            </tr>
            <tr>
                <th><?= __('Amount') ?></th>
                <td><?= $this->Number->currency($invoice->amount) ?></td>
            </tr>
            <tr>
                <th><?= __('Mapped Account') ?></th>
                <td><?= h($invoice->mapped_account) ?></td>
            </tr>
            <tr>
                <th><?= __('Approved') ?></th>
                <td><?php if ($invoice->is_approved): ?><span class="label label-success"><?= __('Yes') ?></span><?php else: ?><span class="label label-danger"><?= __('No') ?></span><?php endif; ?></td>
            </tr>
            <tr>
                <th><?= __('Paid') ?></th>
                <td><?php if ($invoice->is_paid): ?><span class="label label-success"><?= __('Yes') ?></span><?php else: ?><span class="label label-danger"><?= __('No') ?></span><?php endif; ?></td>
            </tr>
            <tr>
                <th><?= __('Created') ?></th>
                <td><?= $invoice->created->timeAgoInWords() ?></td>
            </tr>
            <tr>
                <th><?= __('Modified') ?></th>
                <td><?= $invoice->modified->timeAgoInWords() ?></td>
            </tr>
            </tbody>
        </table>
        <div class="text-center">
            <?= $this->Html->link($this->Image->display($invoice->scan, 'md'), $this->Image->imageUrl($invoice->scan, 'lg'), ['escape' => false, 'class' => 'thumbnail', 'target' => '_blank']) ?>
        </div>
    </div>
</div>
