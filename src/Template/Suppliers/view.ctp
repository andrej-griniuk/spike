<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Supplier $supplier
 */
?>
<ul class="nav nav-pills">
    <li><?= $this->Html->link(__('Edit Supplier'), ['action' => 'edit', $supplier->id]) ?> </li>
    <li><?= $this->Form->postLink(__('Delete Supplier'), ['action' => 'delete', $supplier->id], ['confirm' => __('Are you sure you want to delete # {0}?', $supplier->id)]) ?> </li>
    <li><?= $this->Html->link(__('List Suppliers'), ['action' => 'index']) ?> </li>
    <li><?= $this->Html->link(__('New Supplier'), ['action' => 'add']) ?> </li>
    <li><?= $this->Html->link(__('List Invoices'), ['controller' => 'Invoices', 'action' => 'index']) ?> </li>
    <li><?= $this->Html->link(__('New Invoice'), ['controller' => 'Invoices', 'action' => 'add']) ?> </li>
</ul>
<div class="suppliers view large-9 medium-8 columns content">
    <h3><?= h($supplier->name) ?></h3>
    <table class="vertical-table table table-bordered">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($supplier->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($supplier->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($supplier->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($supplier->modified) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Invoices') ?></h4>
        <?php if (!empty($supplier->invoices)): ?>
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
            <?php foreach ($supplier->invoices as $invoices): ?>
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
