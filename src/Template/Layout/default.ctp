<?php
/**
 * @var \App\View\AppView $this
 */
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->element('Layout/head') ?>
</head>
<body>
    <?= $this->element('Layout/navbar') ?>

    <div class="container">
        <?= $this->Flash->render() ?>
        <?= $this->fetch('content') ?>
    </div>


    <?= $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js') ?>
    <?= $this->Html->script('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js') ?>
    <?= $this->Html->script('moment.min') ?>
    <?= $this->Html->script('bootstrap-datetimepicker.min') ?>
    <?= $this->Html->script('app', ['block' => true]) ?>
    <?= $this->fetch('script') ?>
</body>
</html>
