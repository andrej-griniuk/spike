<?php
/**
 * @var \App\View\AppView $this
 */

$this->Html->css([
    'bootstrap.min',
    'bootstrap-datetimepicker.min',
    'font-awesome.min',
    'app'
], ['block' => true]);
?>
<?= $this->Html->charset() ?>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= $this->fetch('title') ?></title>
<?= $this->Html->meta('icon') ?>
<?= $this->fetch('meta') ?>
<?= $this->fetch('css') ?>
