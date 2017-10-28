<?php
/**
 * @var \App\View\AppView $this
 */
?>
<nav class="navbar">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar">
                <span class="sr-only"><?= __('Toggle navigation') ?></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <?= $this->Html->link($this->Html->image('logo.png'), '/', ['class' => 'navbar-brand', 'escape' => false, 'title' => __('Spike')]) ?>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                <?php if ($this->Auth->user()): ?>
                    <li><?= $this->Html->link(__('Suppliers'), ['controller' => 'Suppliers', 'action' => 'index']) ?></li>
                    <li><?= $this->Html->link(__('Invoices'), ['controller' => 'Invoices', 'action' => 'index']) ?></li>
                    <li><?= $this->Html->link(__('Scan'), ['controller' => 'Invoices', 'action' => 'add']) ?></li>
                    <li role="presentation" class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"> <?= h($this->Auth->user('full_name')) ?> <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><?= $this->Html->link(__('Profile'), ['controller' => 'Users', 'action' => 'profile']) ?></li>
                            <li><?= $this->Html->link(__('Sign Out'), ['controller' => 'Users', 'action' => 'logout']) ?></li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li><?= $this->Html->link(__('Sign In'), ['controller' => 'Users', 'action' => 'login']) ?></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
