<?php
/**
 * @var \App\View\AppView $this
 */

$this->assign('title', __('Sign in to your account'));
?>
<?= $this->Flash->render() ?>
<?= $this->Form->create() ?>
    <?= $this->Form->control('username', ['value' => '10055670']) ?>
    <?= $this->Form->control('password', ['value' => 'aaa111']) ?>
    <?= $this->Form->button(__('Sign in'), ['class' => 'btn btn-primary']) ?>
<?= $this->Form->end() ?>
