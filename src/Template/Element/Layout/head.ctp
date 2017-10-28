<?php
/**
 * @var \App\View\AppView $this
 */

$this->Html->css('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css', ['block' => true]);
$this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js', ['block' => true]);
$this->Html->script('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js', ['block' => true]);
?>
<?= $this->Html->charset() ?>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= $this->fetch('title') ?></title>
<?= $this->Html->meta('icon') ?>
<?= $this->fetch('meta') ?>
<?= $this->fetch('css') ?>
