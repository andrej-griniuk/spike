<?php
/**
 * @var \App\View\AppView $this
 */

$link = Cake\Routing\Router::url(['controller' => 'Invoices', 'action' => 'add', $this->Auth->user('username')], true);
?>
<h2 class="text-center"><?= __('SHARE WITH SUPPLIER') ?></h2>
<p><?= __('Weblink to share with supplier:') ?></p>
<pre><?= $this->Html->link($link, $link) ?></pre>
