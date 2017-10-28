<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Supplier[]|\Cake\Collection\CollectionInterface $suppliers
 */
?>
<ul class="nav nav-pills" style="margin-bottom:10px;">
    <li><?= $this->Html->link(__('New Supplier'), ['action' => 'add']) ?></li>
    <li><?= $this->Html->link(__('List Invoices'), ['controller' => 'Invoices', 'action' => 'index']) ?></li>
    <li><?= $this->Html->link(__('New Invoice'), ['controller' => 'Invoices', 'action' => 'add']) ?></li>
</ul>
<div class="table-responsive">
    <table cellpadding="0" cellspacing="0" class="table table-striped table-hover">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions text-right"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($suppliers as $supplier): ?>
            <tr>
                <td><?= $this->Number->format($supplier->id) ?></td>
                <td><?= h($supplier->name) ?></td>
                <td><?= h($supplier->created) ?></td>
                <td><?= h($supplier->modified) ?></td>
                <td class="actions text-right">
                    <?= $this->Html->link('<i class="fa fa-eye"></i> ' . __('View'), ['action' => 'view', $supplier->id], ['escape' => false, 'class' => 'btn btn-xs btn-info']) ?>
                    <?= $this->Html->link('<i class="fa fa-pencil"></i> ' . __('Edit'), ['action' => 'edit', $supplier->id], ['escape' => false, 'class' => 'btn btn-xs btn-success']) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?= $this->element('pagination') ?>
