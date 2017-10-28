<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Payment $payment
 */

use Cake\Utility\Hash;

?>

<ul class="nav nav-pills" style="margin-bottom:10px;">
    <li><?= $this->Html->link(__('Edit Payment'), ['action' => 'edit', $payment->id]) ?> </li>
    <li><?= $this->Form->postLink(__('Delete Payment'), ['action' => 'delete', $payment->id], ['confirm' => __('Are you sure you want to delete # {0}?', $payment->id)]) ?> </li>
    <li><?= $this->Html->link(__('List Payments'), ['action' => 'index']) ?> </li>
    <li><?= $this->Html->link(__('List Invoices'), ['controller' => 'Invoices', 'action' => 'index']) ?> </li>
</ul>
<div class="payments view large-9 medium-8 columns content table-responsive">
    <table class="table table-striped">
        <tr>
            <th scope="row" style="width:150px"><?= __('ID') ?></th>
            <td><?= $this->Number->format($payment->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Reference') ?></th>
            <td><?= h($payment->reference) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Amount') ?></th>
            <td><?= $this->Number->currency(Hash::get($payment, 'invoice.amount')) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Supplier') ?></th>
            <td><?= h(Hash::get($payment, 'invoice.supplier.name')) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Invoice') ?></th>
            <td>#<?= $this->Html->link(Hash::get($payment, 'invoice.number'), ['controller' => 'Invoices', 'action' => 'view', Hash::get($payment, 'invoice.id')]) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= $payment->created->timeAgoInWords() ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= $payment->modified->timeAgoInWords() ?></td>
        </tr>
    </table>
</div>
