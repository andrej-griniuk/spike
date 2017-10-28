<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Invoice $invoice
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Invoice'), ['action' => 'edit', $invoice->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Invoice'), ['action' => 'delete', $invoice->id], ['confirm' => __('Are you sure you want to delete # {0}?', $invoice->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Invoices'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Invoice'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Suppliers'), ['controller' => 'Suppliers', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Supplier'), ['controller' => 'Suppliers', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Payments'), ['controller' => 'Payments', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Payment'), ['controller' => 'Payments', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="invoices view large-9 medium-8 columns content">
    <h3><?= h($invoice->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $invoice->has('user') ? $this->Html->link($invoice->user->id, ['controller' => 'Users', 'action' => 'view', $invoice->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Supplier') ?></th>
            <td><?= $invoice->has('supplier') ? $this->Html->link($invoice->supplier->name, ['controller' => 'Suppliers', 'action' => 'view', $invoice->supplier->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Payment') ?></th>
            <td><?= $invoice->has('payment') ? $this->Html->link($invoice->payment->id, ['controller' => 'Payments', 'action' => 'view', $invoice->payment->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Number') ?></th>
            <td><?= h($invoice->number) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Mapped Account') ?></th>
            <td><?= h($invoice->mapped_account) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Payment Account Name') ?></th>
            <td><?= h($invoice->payment_account_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Payment Account Token') ?></th>
            <td><?= h($invoice->payment_account_token) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($invoice->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Amount') ?></th>
            <td><?= $this->Number->format($invoice->amount) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Invoice Date') ?></th>
            <td><?= h($invoice->invoice_date) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Due') ?></th>
            <td><?= h($invoice->due) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Payment Date') ?></th>
            <td><?= h($invoice->payment_date) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($invoice->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($invoice->modified) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Is Approved') ?></th>
            <td><?= $invoice->is_approved ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Is Paid') ?></th>
            <td><?= $invoice->is_paid ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Data') ?></h4>
        <?= $this->Text->autoParagraph(h($invoice->data)); ?>
    </div>
</div>
