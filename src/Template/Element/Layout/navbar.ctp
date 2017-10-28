<?php
/**
 * @var \App\View\AppView $this
 */
?>
<nav class="navbar navbar-inverse">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only"><?= __('Toggle navigation') ?></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <?= $this->Html->link(__('InvoicedIn'), '/', ['class' => 'navbar-brand']) ?>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><?= $this->Html->link(__('Forum'), '/forum') ?></li>
                <?php if ($this->Auth->user()): ?>
                    <li role="presentation" class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"> <?= h($this->Auth->user('full_name')) ?> <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <?php if ($this->Auth->user('is_superuser')): ?>
                                <li><?= $this->Html->link(__('Forum Admin'), '/forum/admin') ?></li>
                                <li role="separator" class="divider"></li>
                            <?php endif; ?>
                            <li><?= $this->Html->link(__('Sign Out'), ['controller' => 'Users', 'action' => 'logout', 'prefix' => false, 'plugin' => false]) ?></li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li><?= $this->Html->link(__('Sign In'), ['controller' => 'Users', 'action' => 'login', 'prefix' => false, 'plugin' => false]) ?></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
