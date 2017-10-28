<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Payment[]|\Cake\Collection\CollectionInterface $payments
 */

use Cake\Utility\Hash;

?>
<h2 class="text-center"><?= __('PAYMENTS') ?></h2>
<ul class="nav nav-pills" style="margin-bottom:10px;">
    <li><?= $this->Html->link(__('List Invoices'), ['controller' => 'Invoices', 'action' => 'index']) ?></li>
</ul>
<div class="payments index large-9 medium-8 columns content table-responsive">
    <table cellpadding="0" cellspacing="0" class="table table-striped table-hover">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('reference') ?></th>
                <th scope="col"><?= __('Amount') ?></th>
                <th scope="col"><?= __('Supplier') ?></th>
                <th scope="col"><?= __('Invoice') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($payments as $payment): ?>
            <tr>
                <td><?= $this->Html->link($payment->reference, ['action' => 'view', $payment->id]) ?></td>
                <td><?= $this->Number->currency(Hash::get($payment, 'invoice.amount')) ?></td>
                <td><?= h(Hash::get($payment, 'invoice.supplier.name')) ?></td>
                <td>#<?= $this->Html->link(Hash::get($payment, 'invoice.number'), ['controller' => 'Invoices', 'action' => 'view', Hash::get($payment, 'invoice.id')]) ?></td>
                <td><?= h($payment->created->timeAgoInWords()) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?= $this->element('pagination') ?>
