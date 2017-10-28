<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Payment $payment
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Payment'), ['action' => 'edit', $payment->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Payment'), ['action' => 'delete', $payment->id], ['confirm' => __('Are you sure you want to delete # {0}?', $payment->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Payments'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Payment'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Invoices'), ['controller' => 'Invoices', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Invoice'), ['controller' => 'Invoices', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="payments view large-9 medium-8 columns content">
    <h3><?= h($payment->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Reference') ?></th>
            <td><?= h($payment->reference) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($payment->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($payment->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($payment->modified) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Invoices') ?></h4>
        <?php if (!empty($payment->invoices)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('User Id') ?></th>
                <th scope="col"><?= __('Supplier Id') ?></th>
                <th scope="col"><?= __('Payment Id') ?></th>
                <th scope="col"><?= __('Number') ?></th>
                <th scope="col"><?= __('Invoice Date') ?></th>
                <th scope="col"><?= __('Due') ?></th>
                <th scope="col"><?= __('Amount') ?></th>
                <th scope="col"><?= __('Mapped Account') ?></th>
                <th scope="col"><?= __('Payment Date') ?></th>
                <th scope="col"><?= __('Payment Account Name') ?></th>
                <th scope="col"><?= __('Payment Account Token') ?></th>
                <th scope="col"><?= __('Data') ?></th>
                <th scope="col"><?= __('Is Approved') ?></th>
                <th scope="col"><?= __('Is Paid') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($payment->invoices as $invoices): ?>
            <tr>
                <td><?= h($invoices->id) ?></td>
                <td><?= h($invoices->user_id) ?></td>
                <td><?= h($invoices->supplier_id) ?></td>
                <td><?= h($invoices->payment_id) ?></td>
                <td><?= h($invoices->number) ?></td>
                <td><?= h($invoices->invoice_date) ?></td>
                <td><?= h($invoices->due) ?></td>
                <td><?= h($invoices->amount) ?></td>
                <td><?= h($invoices->mapped_account) ?></td>
                <td><?= h($invoices->payment_date) ?></td>
                <td><?= h($invoices->payment_account_name) ?></td>
                <td><?= h($invoices->payment_account_token) ?></td>
                <td><?= h($invoices->data) ?></td>
                <td><?= h($invoices->is_approved) ?></td>
                <td><?= h($invoices->is_paid) ?></td>
                <td><?= h($invoices->created) ?></td>
                <td><?= h($invoices->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Invoices', 'action' => 'view', $invoices->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Invoices', 'action' => 'edit', $invoices->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Invoices', 'action' => 'delete', $invoices->id], ['confirm' => __('Are you sure you want to delete # {0}?', $invoices->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
