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

    <?= $this->fetch('script') ?>
</body>
</html>
