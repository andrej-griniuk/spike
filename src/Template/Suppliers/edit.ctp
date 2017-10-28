<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Supplier $supplier
 */
?>
<ul class="nav nav-pills">
    <li><?= $this->Form->postLink(
            __('Delete'),
            ['action' => 'delete', $supplier->id],
            ['confirm' => __('Are you sure you want to delete # {0}?', $supplier->id)]
        )
    ?></li>
    <li><?= $this->Html->link(__('List Suppliers'), ['action' => 'index']) ?></li>
    <li><?= $this->Html->link(__('List Invoices'), ['controller' => 'Invoices', 'action' => 'index']) ?></li>
    <li><?= $this->Html->link(__('New Invoice'), ['controller' => 'Invoices', 'action' => 'add']) ?></li>
</ul>
<div class="suppliers form large-9 medium-8 columns content">
    <?= $this->Form->create($supplier) ?>
    <fieldset>
        <legend><?= __('Edit Supplier') ?></legend>
        <?php
            echo $this->Form->control('name');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
